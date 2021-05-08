    <template>
<div>
        <div  class="row card-row col-lg-12">
     <div class="card col-lg-2" v-for="(product,index) in products.data" @key="index">
       
      <img class="card-image" :src="product.image" :alt="product.name">
      
      <div class="card-footer">
        <p class="card-text">Product Name: {{product.name}}</p>
        <h3 class="card-title">Price: $ {{product.price}}</h3>
        <router-link :to="{ path: '/products/'+product.id}">
            <button class="btn btn-sm btn-primary float-right">
                Show Details
            </button>
        </router-link>
       
        
      </div>
    </div>
   

  </div>
  <br>
  <pagination class="justify-content-center pagination" :data="products" @pagination-change-page="getResults"></pagination>
     </div>  
    </template>

    <script>
      export default{
      	data(){
      		return {
      			products:[],
            
      		}
      	},

      	mounted(){
      		

          this.getResults();
      	},
        methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get('api/products?page=' + page)
        .then(response => {
          this.products = response.data;
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
  height: 410px;
  box-shadow: 20px 20px 40px 0px rgba(0,0,0,0.5);
}
.card {
  position: relative;
  background-color: #FFFFFF;
  height: 370px;
  width: 240px;
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
  height: 130px;
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
