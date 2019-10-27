<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Stock List</h3>

                <div class="card-tools">
                 <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-warehouse fa-fw"></i></button>  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Item</th>
                      <th>Opening Stock</th>
                      <th>SDIS</th>
                      <th>SIOS</th>
                      <th>SOH</th>
                      <th>Price/Unit</th>
                      <th>Total</th>
                      <th>Created At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="product in products" :key="product.id">
                      <td>{{product.id}}</td>
                      <td>{{product.item |upText}}</td>
                      <td>{{product.opening_stock}}</td>
                      <td>{{product.sdis}}</td>
                      <td>{{product.sios}}</td>
                      <td>{{product.sohn}}</td>
                      <td>{{product.price_unit}}</td>
                      <td>{{product.total}}</td>
                      <td>{{product.created_at |myDate}}</td>
                      <td>
                          <a href="#" @click="editModal(product)">
                        <i class="fa fa-edit blue"></i>
                          </a>
                          /
                         <a href="#" @click="deleteProduct(product.id)">
                        <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- Modal -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Product Info</h5>
        
        <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateProduct() : createItem()">
      <div class="modal-body">
        <div class="form-group">
      <input v-model="form.item" type="text" name="item"
        placeholder="Enter Item"
        class="form-control" :class="{ 'is-invalid': form.errors.has('item') }">
      <has-error :form="form" field="item"></has-error>
    </div>
    <div class="form-group">
      <input v-model="form.opening_stock" type="text" name="opening_stock"
        placeholder="Enter Opening Stock"
        class="form-control" :class="{ 'is-invalid': form.errors.has('opening_stock') }">
      <has-error :form="form" field="opening_stock"></has-error>
    </div>
    <div class="form-group">
      <input v-model="form.sdis" type="text" name="sdis"
        placeholder="Enter Stock Delivered in Store"
        class="form-control" :class="{ 'is-invalid': form.errors.has('sdis') }">
      <has-error :form="form" field="sdis"></has-error>
    </div>
    <div class="form-group">
      <input v-model="form.sios" type="text" name="sios"
        placeholder="Enter Stock Issued Out of Store"
        class="form-control" :class="{ 'is-invalid': form.errors.has('sios') }">
      <has-error :form="form" field="sios"></has-error>
    </div>
    <div class="form-group">
      <input v-model="form.sohn" type="text" name="sohn"
        placeholder="Enter Stock On Hand Now"
        class="form-control" :class="{ 'is-invalid': form.errors.has('sohn') }">
      <has-error :form="form" field="sohn"></has-error>
    </div>
    <div class="form-group">
      <input v-model="form.price_unit" type="text" name="price_unit"
        placeholder="Enter Price per Unit"
        class="form-control" :class="{ 'is-invalid': form.errors.has('price_unit') }">
      <has-error :form="form" field="price_unit"></has-error>
    </div>
    <div class="form-group">
      <input v-model="form.total" type="text" name="total"
        placeholder="Enter Total"
        class="form-control" :class="{ 'is-invalid': form.errors.has('total') }">
      <has-error :form="form" field="total"></has-error>
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
      </div>
      </form>
    </div>
    
  </div>
</div>
    </div>
</template>

<script>
    export default {
        data(){

return{
    editmode: false,
    products : {},
 
 form: new Form({
        id:'',
        item: '',
        opening_stock: '',
        sdis: '',
        sios: '',
        sohn: '',
        price_unit: '' ,
        total: ''
})
}
        },
        methods: {
             updateProduct(){
       this.$Progress.start();
// console.log('fucksess');
this.form.put('api/product/'+this.form.id)
.then(()=>{
  $('#addNew').modal('hide');
Swal.fire(
      'Updated!',
      'Your file has been Updated.',
      'success'
    ) 
    this.$Progress.finish();
    Fire.$emit('AfterCreate');
})
.catch(()=>{
 this.$Progress.fail();
});
    },
            editModal(product){
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(product);
    },
    newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
    },

deleteProduct(id){
Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  //send request to server
  if(result.value){
this.form.delete('api/product/'+id).then(()=>{  
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )  
    Fire.$emit('AfterCreate');
}).catch(()=>{
Swal("Failed", "Something went Wrong.", "warning");
});
  }
    })
    },
    loadProducts(){
      axios.get("api/product").then(({data}) => (this.products =data.data));
    },

       createItem(){
       this.$Progress.start();
       this.form.post('api/product')
       .then(()=>{
       Fire.$emit('AfterCreate');
        $('#addNew').modal('hide');
       Toast.fire({
  type: 'success',
  title: 'Item Created successfully'
})
       this.$Progress.finish();
       })
       .catch(()=>{

       })
       
      }
     

  },
        created() {
           this.loadProducts();
            Fire.$on('AfterCreate',() =>{
            this.loadProducts();
            });

        }
    }
</script>
