<template>

   <div>
        <h3 class="text-center">All Your Orders</h3>
        <div  class="row card-row col-lg-12">
     <div class="card col-lg-2"v-for="(order,index) in orders.data" @key="index">
       
      <img class="card-image" :src="order.product.image" :alt="order.product.name">
      
      <div class="card-footer">
        <h5 class="card-text">Product: {{order.product.name}}</h5>
        <h5 class="card-title">Unit  Price: $ {{order.product.price}}</h5>
        <h5 class="card-title">Quantity: {{order.quantity}}</h5>
        <h5 class="card-title">Created: {{order.created_at}}</h5>
        <h5 class="">{{order.is_delivered == 1? "shipped!" : "not shipped"}}</h5>
        <p><strong>Delivery address:</strong> <br>{{order.address}}</p>
       
        
      </div>
    </div>
   

  </div>
   <br>
  <pagination class="justify-content-center pagination" :data="orders" @pagination-change-page="getResults"></pagination>
   
     </div> 

    </template>
    
    <script>
    export default {
        data() {
            return {
                user : null,
                orders : []
            }
        },
        beforeMount() {
            this.user = JSON.parse(localStorage.getItem('loggedUserToken.user'))

            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('loggedUserToken.jwt')

        
                 this.getResults();
        }
        ,
        methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get(`api/users/${this.user.id}/orders?page=` + page)
        .then(response => {
          this.orders = response.data;
        });
    }
  }
    }
    </script>

       <style scoped>

    body {
  background-color: #E1E7E7;
}

.card-row {
  display: flex;
  justify-content: center;
  align-items: center;  
  
}
.card {
 
  transition: height 0.3s, box-shadow 0.3s;
}
.card:hover {
  height: 520px;
  box-shadow: 20px 20px 40px 0px rgba(0,0,0,0.5);

}
.card {
  position: relative;
  background-color: #FFFFFF;
  height: 500px;
  width: 500px;
  margin: 10px;
  overflow: hidden;
  box-shadow: 0px 2px 4px 0px rgba(0,0,0,0.5);
}
.card-image {

  position: absolute;
 
  margin: auto;

  height: 220px;
  min-width: 100%;
}
.card-footer {
  position: absolute;
  bottom: 0;
  height: 250px;
  padding: 10px 15px;
  font-family: Helvetica;
}
.card-text {
  font-size: 14px;
  color: rgba(0, 0, 0, 0.7);
}
.card-title {
  font-family: Serif;
}
.card-author {
  font-size: 14px;
  color: #BAB096;
}
.btn{background-color: #C223CE;border-color: #C223CE; }
.btn:hover{background-color: #0a575a;border-color: #0a575a;}
    
    </style>