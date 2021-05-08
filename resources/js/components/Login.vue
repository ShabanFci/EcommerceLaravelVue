<template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">Login</div>
                        
                        <div class="card-body">
                            <span class="error row justify-content-center" v-if="credentials">* {{credentials}} *</span>
                            <br>
                            <form>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                        <span v-if="errors.email" class="error">*{{errors.email[0]}}*</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" v-model="password" required>
                                        <span v-if="errors.password" class="error">*{{errors.password[0]}}*</span>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn login" @click="handleSubmit">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
        export default{
            data(){
                return {
                    email: "",
                    password: "",
                    errors: [],
                    credentials: ""
                } 
            },

            mounted(){
             let user =  localStorage.getItem('loggedUserToken.user', JSON.stringify(user));
             if(user != null){
                this.$router.push('/')
             }
            },
            methods:{
                
                handleSubmit(e){
                    this.errors = []
                    this.credentials = ""
                    e.preventDefault()
                    
                       let email = this.email 
                       let password = this.password
                       axios.post('api/login',{email,password}).then(response => {

                        let user = response.data.user
                        let is_admin = user.is_admin

                        localStorage.setItem('loggedUserToken.user', JSON.stringify(user))
                        localStorage.setItem('loggedUserToken.jwt', response.data.token)
                        if (localStorage.getItem('loggedUserToken.jwt') != null) {
                            this.$emit('loggedIn')
                            if (this.$route.params.nextUrl != null) {
                                    this.$router.push(this.$route.params.nextUrl)
                                } else {
                                    this.$router.push((is_admin == 1 ? 'admin' : 'dashboard'))
                                }

                        }
                       }).catch(error => {
                         if(error.response.status == 422){
                            this.errors = error.response.data.errors
                            
    
                        }
                        if(error.response.status == 401){
                          
                            this.credentials = error.response.data.credentials 
    
                        }
                        
                       

                        
                       })
                    
                    
                }
            }
           
        }
    </script>

    <style scoped>
      .card{
        background-color: #875a85;
        margin-top : 50px
      }
      .login{
        background-color: #0a575a;
        border-color: #0a575a;
        color: #fff

      }
      .card-header {
        text-align : center;
        color : #fff
      }
      label {
        color : #fff
      }
    </style>
    