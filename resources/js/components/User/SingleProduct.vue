<template>
        <div class="container">
            
  <div class="card">
     <div class="card__image-container">
        <h3 class="card__title">{{product.name}}</h3>
       <img class="card__image" :src="product.image" :alt="product.name"><br><br>
    </div> 
     
       
       <h4 class="float-right">Price : ${{product.price}}</h4>
       <h4>Available Quantities : {{product.units}} Items</h4>
     <h5>Description : {{product.description}}</h5><br>

    <router-link :to="{ path: '/checkout?pid='+product.id }" class="col-md-4 btn">Buy Now</router-link>
  </div>

        </div>
    </template>
<script>
    export default {
        data(){
            return {
                product : []
            }
        },
        beforeMount(){
            let url = `/api/products/${this.$route.params.id}`
            axios.get(url).then(response => this.product = response.data)      
        }
    }
    </script>

    <style scoped>
    * {
  box-sizing: border-box;
  
  font-family: 'Open Sans', sans-serif;
}

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
  background: #333;
  width: 400px;
 
  border-radius: 6px;
  padding: 2rem;
  color: #fff;
  box-shadow: 0 .25rem .25rem rgba(0,0,0,0.2),
    0 0 1rem rgba(0,0,0,0.2);
  overflow: hidden;
  
  }
  .btn{ background-color: #C223CE;border-color:#C223CE;color:#fff}
  
  </style>