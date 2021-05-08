<template>
    <div>
    <div class="container">
            
  <div class="card">
     <div class="card__image-container">
        <h3 class="card__title">{{product.name}}</h3>
       <img class="card__image" :src="product.image" :alt="product.name"><br><br>
    </div> 
     
       
       <h4 class="float-right">Unit Price : ${{product.price}}</h4>
       <p class="small-textp float-right">Available Units: {{product.units}}</p>

        <label class="row"><span class="col-md-4 float-left">Quantity: </span><input type="number" name="units" min="1" :max="product.units" class="col-md-4 float-left" v-model="quantity" @change="checkUnits"></label>
<div>
                        <div v-if="!isLoggedIn">
                            <h3 style="color:#888">You need to login to Place Order</h3>
                            <button class="col-md-4 btn btn-success float-left" @click="login">Login</button>
                            <button class="col-md-6 btn btn-primary float-right" @click="register">Create an account</button>
                        </div>
                        <div v-if="isLoggedIn">
                            <div class="row">
                                <label for="address" class="col-md-3 col-form-label">Delivery Address</label>
                                <div class="col-md-12">
                                    <input id="address" type="text" class="form-control" required="required" v-model="address" >
                                
                                <span v-if="errors.address" class="error">*{{errors.address[0]}}*</span>
                                </div>
                            </div>
                            <br>
                            <button class="col-md-4 btn btn-sm btn-success float-right" v-if="isLoggedIn" @click="placeOrder">Place Order</button>
                        </div>
                    </div>
   
  </div>

        </div>

</div>


      
    </template>


    <script>
    export default {
        props : ['pid'],
        data(){
            return {
                
                quantity : 1,
                isLoggedIn : null,
                product : [], 
                errors: []

            }
        },
        mounted() {
            this.isLoggedIn = localStorage.getItem('loggedUserToken.jwt') != null
        },
        beforeMount() {
            axios.get(`/api/products/${this.pid}`).then(response => this.product = response.data)

            if (localStorage.getItem('loggedUserToken.jwt') != null) {
                this.user = JSON.parse(localStorage.getItem('loggedUserToken.user'))
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('loggedUserToken.jwt')
            }
        },
        methods : {
            login() {
                this.$router.push({name: 'login', params: {nextUrl: this.$route.fullPath}})
            },
            register() {
                this.$router.push({name: 'register', params: {nextUrl: this.$route.fullPath}})
            },
            placeOrder(e) {
                e.preventDefault()

                let address = this.address
                let product_id = this.product.id
                let quantity = this.quantity
              
                axios.post('api/orders/', {address, quantity, product_id})
                     .then(response => this.$router.push('/confirmation'))
                     .catch(error => {
                         if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                       })
            },
            checkUnits(e){
                if (this.quantity > this.product.units) {
                    this.quantity = this.product.units
                }
            }
        }
    }
    </script>

    <style scoped>
 

img {
  max-width: 100%;
}

.container {
  display: flex;
  align-items: center;
  justify-content: center;
  padding:20px;
  
  background: #33403042;
}

.card {
  position: relative;
  background: #15040400;
  width: 400px;
 
  border-radius: 6px;
  padding: 2rem;
  color: #000;
  box-shadow: 0 .25rem .25rem rgba(0,0,0,0.2),
    0 0 1rem rgba(0,0,0,0.2);
  overflow: hidden;
  
  }
  

    </style>