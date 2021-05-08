<template>
<div>
    <nav class="navbar navbar-expand-md navbar-light" style="background-color: rgb(10, 87, 90)">
        <div class="container">
            <router-link :to="{name: 'home'}" class="navbar-brand"><img class="logo" v-bind:src="'logo.jpg'">Egyption Store</router-link>
            <router-link style="color:#fff" :to="{ name: 'userboard' }" class="nav-link" v-if="user_type == 0"> Show Your Orders</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul>
                   <!--  <li v-if="user_type == 0">Show Orders</li> -->
                </ul>
                <ul class="navbar-nav mr-auto"></ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <router-link :to="{ name: 'login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
                    <router-link :to="{ name: 'register' }" class="nav-link" v-if="!isLoggedIn">Register</router-link>
                    <span v-if="isLoggedIn">
                        <router-link :to="{ name: 'userboard' }" class="nav-link" v-if="user_type == 0"> Hi, {{name}}</router-link>

                        <router-link :to="{ name: 'admin' }" class="nav-link" v-if="user_type == 1"> Hi, {{name}}</router-link>
                    </span>
                    <li class="nav-link logout" v-if="isLoggedIn" @click="logout"> Logout</li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <router-view @loggedIn="change"></router-view>
    </main>

</div>
    
    </template>
<appFooter></appFooter>

    <script>
        export default{
            data(){
                return {
                    name : null ,
                    user_type : 0 ,
                    isLoggedIn : localStorage.getItem('loggedUserToken.jwt') != null
                }

            },
            mounted(){
                this.setDefaults();
            },
            methods : {
                setDefaults(){
                    if(this.isLoggedIn){
                        let user = JSON.parse(localStorage.getItem('loggedUserToken.user'))
                        this.name = user.name
                        this.user_type = user.is_admin
                    }
                },
                change(){
                    this.isLoggedIn = localStorage.getItem('loggedUserToken.jwt')!= null
                    this.setDefaults()
                },
                logout(){
                    localStorage.removeItem('loggedUserToken.jwt')
                    localStorage.removeItem('loggedUserToken.user')
                    this.change()
                    this.$router.push('/')
                }
            }
        }
    </script>
    
    <style>
      .logout:hover{
        cursor:pointer
      }
      .navbar-light .navbar-nav .nav-link {
        color : #fff
      }
      .logo{
        width:80px;
        height : 50px;
        border : 2px solid #fff;
        border-radius :50px;
      }
      .navbar-brand{
        color : #61c2bd;
        font-weight :bold;
        border : 1px solid #fff;
        border-radius :20px;
        padding : 8px;
        padding-right: 20px;
        background-color :#fff
      }
      .navbar-brand:hover{
        color : #61c2bd;

      }
      .error{ color: #e6150;font-weight: bold;}

    </style>