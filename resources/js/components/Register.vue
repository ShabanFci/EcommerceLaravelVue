<template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">Register</div>
                        <div class="card-body">
                            <form>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                                        <span v-if="errors.name" class="error">*{{errors.name[0]}}*</span>
                                    </div>
                                    
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" v-model="email" required>
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
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                                        <span v-if="errors.c_password" class="error">*{{errors.c_password[0]}}*</span>
                                    </div>
                                    
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn register" @click="handleSubmit">
                                            Register
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
    export default {
        props : ['nextUrl'],
        data(){
            return {
                name : "",
                email : "",
                password : "",
                password_confirmation : "",
                errors: []
            }
        },
        mounted(){
             let user =  localStorage.getItem('loggedUserToken.user', JSON.stringify(user));
             if(user != null){
                this.$router.push('/')
             }
            },
        methods : {
            handleSubmit(e) {
                this.errors = []
                e.preventDefault()
               
                let name = this.name
                let email = this.email
                let password = this.password
                let c_password = this.password_confirmation
                axios.post('api/register', {name, email, password, c_password}).then(response => {
                    let data = response.data
                    localStorage.setItem('loggedUserToken.user', JSON.stringify(data.user))
                    localStorage.setItem('loggedUserToken.jwt', data.token)
                    if (localStorage.getItem('loggedUserToken.jwt') != null) {
                        this.$emit('loggedIn')
                        let nextUrl = this.$route.params.nextUrl
                        this.$router.push((nextUrl != null ? nextUrl : '/'))
                    }
                }).catch(error => {
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
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
      .register{
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