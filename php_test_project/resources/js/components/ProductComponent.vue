<template>
  <div class="container my-5">
      <div class="row justify-content-end mb-3">
          <div class="col-4">
                <button class="btn btn-primary" @click="create">
                    <i class="fas fa-plus-circle"></i>
                    Create
                </button>
          </div>
          <div class="col-4">
              <form @submit.prevent="searchProduct">
                  <div class="input-group">
                      <input v-model="search" type="text" placeholder="Search" class="form-control">
                      <div class="input-group-append">
                          <button type="submit" class="btn btn-primary">
                              <i class="fas fa-search"></i>
                          </button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      <div class="row">
          <div class="col-4">
              <div class="card">
                  <h4 class="card-header">{{isEditMode ? 'Edit' : 'Create'}}</h4>
                <div class="card-body">
                    <form @submit.prevent="isEditMode ? update() : store()">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input v-model="product.name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Price:</label>
                            <input v-model="product.price" type="number" class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i>Save</button>
                    </form>
                </div>
              </div>
          </div>
          <div class="col-8">
              <table class="table">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Price</th>
                          <th>Actio</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="product in products" :key="product.id">
                          <td>{{product.id}}</td>
                          <td>{{product.name}}</td>
                          <td>{{product.price}}</td>
                          <td>
                            <button class="btn btn-success btn-sm" @click="edit(product)"><i class="fas fa-edit mr-1"></i>Edit</button>
                            <button class="btn btn-danger btn-sm" @click="destory(product.id)"><i class="fas fa-trash-alt mr-1"></i>Delete</button>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    name: 'ProductConpoment',
    data(){
        return{
            isEditMode: false,
            search:'',
            products:[],
            product:{
                id:'',
                name:'',
                price:''
            }
        }
    },
    methods:{
        searchProduct(){
            axios.get('/api/product?search='+this.search)
            .then((response)=>{this.products = response.data});
        },
        view(){
            axios.get('/api/product').then((response)=>{this.products = response.data});
        },
        create(){
            this.isEditMode = false;
            this.product.id = '';
            this.product.name = '';
            this.product.price = '';
        },
        store(){
            axios.post('/api/product',this.product)
            .then(response=>{
                this.view();
                this.product.id = '';
                this.product.name = '';
                this.product.price = '';
                });
        },
        edit(product){
            this.isEditMode = true;
            this.product.id = product.id;
            this.product.name = product.name;
            this.product.price = product.price;
        },
        update(){
            axios.put(`/api/product/${this.product.id}`, this.product)
            .then((response)=>{
                this.view();
                this.product.id = '';
                this.product.name = '';
                this.product.price = '';
                this.isEditMode = false;
            })
        },
        destory(id){
            axios.delete(`/api/product/${id}`)
            .then((response=>{
                this.view();
            }));
        },
    },
    created(){
        this.view();
    }
}
</script>

<style>

</style>