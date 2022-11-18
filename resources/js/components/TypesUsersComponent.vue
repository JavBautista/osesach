<template>
    <div class="container">
        <div class="container-fluid">
            <!--Card-->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Tipos de usuarios
                    <button type="button" @click="abrirModal('type','registrar')" class="btn btn-primary float-rigth">
                        <i class="bi bi-plus-circle"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="description">Descripción</option>
                            </select>
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadTypes(1,buscar,criterio)">
                            <button type="submit" @click="loadTypes(1,buscar,criterio)" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                        </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>DESCRIPCIÓN</th>

                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="type_emp in arrayTypes" :key="type_emp.id">
                                    <td v-text="type_emp.description"></td>

                                    <td>
                                        <button type="button" class="btn btn-outline-info" @click="abrirModal('type','actualizar_datos', type_emp)" title="Editar"><i class="bi bi-pencil-square"></i></button>

                                    </td>
                                </tr>
                            </tbody>

                        </table>
                        <nav>
                            <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                            </li>

                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>

                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                            </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!--./Card Productos-->
        </div>
        <!--.container-->
        <!--Modal-->
        <div class="modal fade" tabindex="-1" :class="{ 'mostrar':modal }" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form v-on:submit.prevent action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div v-show="error" class="form-group row div-error">
                                <div class="container-fluid">
                                    <div class="alert alert-danger text-center">
                                        <div v-for="error in errorMostrarMsj" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p><em><strong class="text text-danger">* Campos obligatorios</strong></em></p>
                            <!--tipoAccion==1 o 2: Agregar o ACtualizar-->
                            <div v-if="tipoAccion==1 || tipoAccion==2">
                            <!--<div v-else>-->
                                <div class="form-group">
                                    <label for="description"><strong class="text text-danger">*</strong>Descripcion</label>
                                    <input type="text" class="form-control" v-model="description" placeholder="Ingrese descripción" required>
                                </div>

                            </div>
                            <!--./tipoAccion==1 o 2: Agregar o ACtualizar-->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrar()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarDatos()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--.Modal-->
    </div>
</template>

<script>

    export default {
        data(){
            return {

              arrayTypes:[],
              pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },
              offset:3,
              criterio:'description',
              buscar:'',

              type_id:0,
              type:0,
              description:'',

              errors:[],

              modal:0,
              tituloModal:'',
              tipoAccion:0,
              error:0,
              errorMostrarMsj:[],
            }
        },
        computed:{
           isActived: function(){
            return this.pagination.current_page;
           },
           //Calcula los elementos de la paginacion
           pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from <1){
                    from=1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to ){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
           }
        },
        methods:{
            loadTypes(page,buscar,criterio){
                let me=this;
                var url = '/tipos-usuarios/get?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response){
                    let respuesta = response.data;
                    me.arrayTypes = respuesta.types_user.data;
                    me.pagination = respuesta.pagination;
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.loadTypes(page,buscar,criterio);
            },
            validarDatos(){
                this.error=0;
                this.errorMostrarMsj=[];
                if(!this.description) this.errorMostrarMsj.push('El valor descripcion no puede estar vacio.');
                if(this.errorMostrarMsj.length) this.error=1;
                return this.error;
            },
            registrar(){
                if(this.validarDatos()){
                    return;
                }
                let me=this;
                axios.post('/tipos-usuarios/store',{
                  'description':me.description

                }).then(function (response){
                  console.log(response)
                  me.cerrarModal();
                  me.loadTypes(me.pagination.current_page,me.buscar,me.criterio)
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarDatos(){
                if(this.validarDatos()){
                    return;
                }
                let me=this;
                axios.put('/tipos-usuarios/update',{
                  'id':me.type_id,
                  'description':me.description
                }).then(function (response){
                  //console.log(response)
                  me.cerrarModal();
                  me.loadTypes(me.pagination.current_page,me.buscar,me.criterio)
                }).catch(function (error){
                    console.log(error);
                });
            },

            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "type":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Agregar';
                                this.description='';
                                break;
                            }
                            case 'actualizar_datos':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar';
                                this.type_id     = data['id'];
                                this.description = data['description'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
        },
        mounted() {
            console.log('types-users-component load')
            this.loadTypes(1,'','description');
        }
    }
</script>


<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #3c29297a !important;
        overflow: scroll;
    }

    .div-error{
        display: flex;
        justify-content: center;
    }

    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
