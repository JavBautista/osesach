<template>
<div>
    <div class="container-fluid">
        <!--Card-->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Personal
                <button type="button" @click="abrirModal('personal','registrar')" class="btn btn-primary float-rigth">
                    <i class="bi bi-plus-circle"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <select class="form-select col-md-3" v-model="filtro_tipo">
                            <option value="todos">Todos</option>
                            <option value="agentes">Agentes</option>
                            <option value="supervisores">Supervidores</option>
                            <option value="admin">Administrativos</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="name">Nombre</option>
                                <option value="address">Dirección</option>
                                <option value="movil">Teléfono</option>
                                <option value="email">Email</option>
                            </select>
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadPersonal(1,buscar,criterio, filtro_tipo)">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <button type="submit" @click="loadPersonal(1,buscar,criterio,filtro_tipo)" class="btn btn-lg btn-info px-4"><i class="bi bi-search"></i> Filtrar</button>
                    </div>
                </div>

                <div class="container-fluid">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Estatus</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Direccion</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Fecha ingreso</th>
                                <th>Fecha salida</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="personal in arrayPersonal" :key="personal.id">
                                <td>
                                    <div class="dropdown">
                                      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" @click="abrirModal('personal','ver_datos', personal)" ><i class="bi bi-eye"></i> Ver Ficha</a></li>
                                        <li><a class="dropdown-item" href="#" @click="abrirModal('personal','actualizar_datos', personal)"><i class="bi bi-pencil-square"></i> Editar</a></li>

                                        <li>
                                            <a v-if="personal.active" class="dropdown-item" href="#" @click="editInactive(personal.id)"> <i class="bi bi-hand-thumbs-down"></i> Desactivar</a>
                                            <a v-else class="dropdown-item" href="#" @click="editActive(personal.id)"><i class="bi bi-hand-thumbs-up"></i> Activar</a>
                                        </li>

                                      </ul>
                                    </div>
                                </td>
                                <td>
                                    <span v-if="personal.active" class="badge bg-success">Activo</span>
                                    <span v-else class="badge bg-danger">Baja</span>
                                </td>
                                <td v-text="personal.name"></td>
                                <td v-text="personal.description"></td>
                                <td v-text="personal.address"></td>
                                <td v-text="personal.movil"></td>
                                <td v-text="personal.email"></td>
                                <td v-text="personal.date_admission"></td>
                                <td v-text="personal.date_termination"></td>
                                <td v-text="personal.observations"></td>
                            </tr>
                        </tbody>

                    </table>
                    <nav>
                        <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio,filtro_tipo)">Ant</a>
                        </li>

                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,filtro_tipo)" v-text="page"></a>
                        </li>

                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio,filtro_tipo)">Sig</a>
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

                            <template v-if="tipoAccion==1" >
                            <div class="form-group row mb-2">
                                <label class="col-md-3 3ol-form-label text-md-right" for="role_user"><strong class="text text-danger">*</strong>Tipo Usuario</label>
                                <div class="col-sm-9">
                                  <select class="form-control" v-model="role_id">
                                      <option v-for="role in arrayRolesUser" :key="role.id" :value="role.id" v-text="role.description"></option>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label for="email" class="col-md-3 3ol-form-label text-md-right"><strong class="text text-danger">*</strong>Email</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="email" placeholder="Email" required>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label for="password" class="col-md-3 col-form-label text-md-right"><strong class="text text-danger">*</strong>Password</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" v-model="password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label for="password-confirm" class="col-md-3 col-form-label text-md-right"><strong class="text text-danger">*</strong>Confirm Password</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" v-model="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="date" class="col-md-3 col-form-label text-md-right">
                                    <strong class="text text-danger">*</strong>Fecha de ingreso
                                </label>
                                <div class="col-md-9">
                                    <datepicker v-model="date_admission"></datepicker>
                                </div>
                            </div>


                            </template>
                            <div class="form-group">
                                <label for="name"><strong class="text text-danger">*</strong>Nombre</label>
                                <input type="text" class="form-control" v-model="name" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input type="text" class="form-control" v-model="address" required>
                            </div>

                            <div class="form-group">
                                <label for="movil">Teléfono</label>
                                <input type="text" class="form-control" v-model="movil" required>
                            </div>



                            <div class="form-group">
                                <label for="observations">Observaciones</label>
                                <input type="text" class="form-control" v-model="observations" required>
                            </div>

                        </div>
                        <!--./tipoAccion==1 o 2: Agregar o ACtualizar-->
                        <!--tipoAccion==3 Ver-->
                        <div v-if="tipoAccion==3">


                            <div class="form-group row mb-2">
                                <label class="col-md-3 3ol-form-label text-md-right" for="role_user"><strong class="text text-danger">*</strong>Tipo Usuario</label>
                                <div class="col-sm-9">
                                  <select class="form-control" v-model="role_id" readonly>
                                      <option v-for="role in arrayRolesUser" :key="role.id" :value="role.id"   v-text="role.description"></option>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label for="email" class="col-md-3 3ol-form-label text-md-right"><strong class="text text-danger">*</strong>Email</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="email" placeholder="Email" readonly>
                                </div>
                            </div>


                            <hr>
                            <div class="form-group row">
                                <label for="date" class="col-md-3 col-form-label text-md-right">
                                    <strong class="text text-danger">*</strong>Fecha de ingreso
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="date_admission" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name"><strong class="text text-danger">*</strong>Nombre</label>
                                <input type="text" class="form-control" v-model="name" readonly>
                            </div>

                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input type="text" class="form-control" v-model="address" readonly>
                            </div>

                            <div class="form-group">
                                <label for="movil">Teléfono</label>
                                <input type="text" class="form-control" v-model="movil" readonly>
                            </div>



                            <div class="form-group">
                                <label for="observations">Observaciones</label>
                                <input type="text" class="form-control" v-model="observations" readonly>
                            </div>

                        </div>
                        <!--./tipoAccion==3 Ver-->
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
    import Datepicker from 'vuejs-datepicker'
    import { es } from 'vuejs-datepicker/dist/locale'
    import moment from "moment";
    export default {
        components: {
            Datepicker
        },
        data(){
            return {

              arrayPersonal:[],
              arrayRolesUser:[],
              pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },
              offset:3,
              criterio:'name',
              filtro_tipo:'todos',
              buscar:'',

              personal_id:0,

              email:'',
              password:'',
              password_confirmation:'',
              role_id:0,
              name:'',
              address:'',
              movil:'',
              date_admission:'',
              observations:'',

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
            loadRolesUser(){
                let me=this;
                var url = '/roles-usuarios/get/all';
                axios.get(url).then(function (response){
                    console.log('Roles')
                    console.log(response.data)
                    me.arrayRolesUser = response.data;
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            loadPersonal(page,buscar,criterio,filtro_tipo){
                let me=this;
                var url = '/personal/get?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&filtro_tipo='+filtro_tipo;
                axios.get(url).then(function (response){
                    console.log(response)
                    let respuesta = response.data;
                    me.arrayPersonal = respuesta.people.data;
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
            cambiarPagina(page,buscar,criterio,filtro_tipo){
                let me = this;
                me.pagination.current_page = page;
                me.loadPersonal(page,buscar,criterio,filtro_tipo);
            },
            validarDatos(accion){
                this.error=0;
                this.errorMostrarMsj=[];
                if(accion=='registrar'){

                    if(!this.name) this.errorMostrarMsj.push('El valor nombre no puede estar vacio.');
                    if(!this.email) this.errorMostrarMsj.push('El email no puede estar vacio.');
                    if(!this.password) this.errorMostrarMsj.push('El password no puede estar vacio.');
                    if(this.password!==this.password_confirmation) this.errorMostrarMsj.push('Los passwords no coindide.');
                }
                if(accion=='actualizar'){
                    if(!this.name) this.errorMostrarMsj.push('El valor nombre no puede estar vacio.');
                }

                if(this.errorMostrarMsj.length) this.error=1;
                return this.error;
            },
            registrar(){
                if(this.validarDatos('registrar')){
                    return;
                }

                console.log('A guardar')
                let me=this;
                let formatted_date = moment(me.date_admission).format('YYYY-MM-DD')

                console.log(` Store nuevo:
                name: ${me.name}
                , address: ${me.address}
                , movil: ${me.movil}
                , formatted_date: ${formatted_date}
                , observations: ${me.observations}
                , email: ${me.email}
                , password: ${me.password}
                , role_id: ${me.role_id}`
                );

                axios.post('/personal/store',{
                  'name': me.name,
                  'address': me.address,
                  'movil': me.movil,
                  'date_admission': formatted_date,
                  'observations': me.observations,
                  'email':me.email,
                  'password':me.password,
                  'role_id':me.role_id,

                }).then(function (response){
                  //console.log(response)
                  me.cerrarModal();
                  me.loadPersonal(me.pagination.current_page,me.buscar,me.criterio, me.filtro_tipo)
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarDatos(){
                if(this.validarDatos('actualizar')){
                    return;
                }
                let me=this;
                let formatted_date = moment(me.date_admission).format('YYYY-MM-DD')
                axios.put('/personal/update',{
                  'id':me.personal_id,
                  'name':me.name,
                  'address':me.address,
                  'movil':me.movil,
                  'date_admission':formatted_date,
                  'observations':me.observations,
                }).then(function (response){
                  //console.log(response)
                  me.cerrarModal();
                  me.loadPersonal(me.pagination.current_page,me.buscar,me.criterio, me.filtro_tipo)
                }).catch(function (error){
                    console.log(error);
                });
            },

            editActive(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea cambiar a activo?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/personal/active',{
                        'id': id
                    }).then(function (response){
                        me.loadPersonal(me.pagination.current_page,me.buscar,me.criterio,me.filtro_tipo);
                        swalWithBootstrapButtons.fire(
                          'Activo',
                          'El registro ha sido actualizado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
            editInactive(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea cambiar a inactivo?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                    let me=this;
                    axios.put('/personal/inactive',{
                        'id': id
                    }).then(function (response){
                        me.loadPersonal(me.pagination.current_page,me.buscar,me.criterio,me.filtro_tipo);
                        swalWithBootstrapButtons.fire(
                          'Inactivo',
                          'El registro ha sido actualizado con exito.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });
                  }
                })
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "personal":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Agregar';
                                this.active=0;
                                this.name='';
                                this.address='';
                                this.movil='';
                                this.email='';
                                this.password='';
                                this.password_confirmation='';
                                this.date_admission='';
                                this.observations='';
                                break;
                            }
                            case 'actualizar_datos':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar';
                                this.personal_id= data['id'];
                                this.name= data['name'];
                                this.address= data['address'];
                                this.movil= data['movil'];
                                this.email= data['email'];
                                this.date_admission= data['date_admission'];
                                this.observations= data['observations'];
                                break;
                            }
                            case 'ver_datos':{
                                this.modal=1;
                                this.tipoAccion =3;
                                this.tituloModal='Ver';

                                this.personal_id= data['id'];
                                this.name= data['name'];
                                this.address= data['address'];
                                this.movil= data['movil'];
                                this.email= data['email'];
                                this.date_admission= data['date_admission'];
                                this.observations= data['observations'];
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
            this.loadPersonal(1,'','name','todos');
            this.loadRolesUser();
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
