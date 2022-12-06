<template>
<div>
    <div class="container-fluid">
        <!--Card-->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Directorio
                <button type="button" @click="abrirModal('directorio','registrar')" class="btn btn-primary float-rigth">
                    <i class="bi bi-plus-circle"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="actividad_key">
                                <option value="0">Todos</option>
                                <option v-for="act in arrayActividades" :key="act.key" :value="act.key">{{act.activity}} - {{act.key}}  </option>
                            </select>
                            <label for="floatingSelect">Actividad económica</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_tam_est">
                                <option value="0">Todos los tamaños</option>
                                <option value="1">0 a 5 personas</option>
                                <option value="2">6 a 10 personas</option>
                                <option value="3">11 a 30 personas</option>
                                <option value="4">31 a 50 personas</option>
                                <option value="5">51 a 100 personas</option>
                                <option value="6">101 a 250 personas</option>
                                <option value="7">251 y más personas</option>
                            </select>
                            <label for="floatingSelect">Tamaño del estabecimiento</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_tipo_asentamiento">
                                    <option value="TODOS">TODOS</option>
                                    <option value="COLONIA">COLONIA</option>
                                    <option value="FRACCIONAMIENTO">FRACCIONAMIENTO</option>
                                    <option value="LOCALIDAD">LOCALIDAD</option>
                                    <option value="PUEBLO">PUEBLO</option>
                                    <option value="BARRIO">BARRIO</option>
                                    <option value="RESIDENCIAL">RESIDENCIAL</option>
                                    <option value="CONJUNTO HABITACIONAL">CONJUNTO HABITACIONAL</option>
                                    <option value="ZONA COMERCIAL">ZONA COMERCIAL</option>
                                    <option value="MANZANA">MANZANA</option>
                                    <option value="OTRO (ESPECIFIQUE)">OTRO (ESPECIFIQUE)</option>
                                    <option value="EXHACIENDA">EXHACIENDA</option>
                                    <option value="CIUDAD">CIUDAD</option>
                                    <option value="HACIENDA">HACIENDA</option>
                                    <option value="RINCONADA">RINCONADA</option>
                                    <option value="AEROPUERTO">AEROPUERTO</option>
                                    <option value="RANCHERIA">RANCHERIA</option>
                                    <option value="UNIDAD HABITACIONAL">UNIDAD HABITACIONAL</option>
                                    <option value="PRIVADA">PRIVADA</option>
                                    <option value="NINGUNO">NINGUNO</option>
                                    <option value="COTO">COTO</option>
                                    <option value="UNIDAD">UNIDAD</option>
                                    <option value="CONDOMINIO">CONDOMINIO</option>
                                    <option value="ZONA FEDERAL">ZONA FEDERAL</option>
                            </select>
                            <label for="floatingSelect">Tipo asentamiento</label>
                        </div>
                    </div>
                </div>
                <!--./form-group row 1-->

                <div class="form-group row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_localidad">
                                <option value="TODOS">Todos</option>
                                <option v-for="loc in arrayLocalidades" :key="loc.id" :value="loc.description" v-text="loc.description"></option>
                            </select>
                            <label for="floatingSelect">Localidad</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_incorporacion">
                                <option value="TODOS">Todos</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                            </select>
                            <label for="floatingSelect">Año incorporación</label>
                        </div>
                    </div>
                </div>
                <!--./form-group row 2-->

                <div class="form-group row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_telefono">
                                <option value="TODOS">Todos</option>
                                <option value="con">Con</option>
                                <option value="sin">Sin</option>

                            </select>
                            <label for="floatingSelect">Teléfono</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_email">
                                <option value="TODOS">Todos</option>
                                <option value="con">Con</option>
                                <option value="sin">Sin</option>
                            </select>
                            <label for="floatingSelect">Email</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_pagina_web">
                               <option value="TODOS">Todos</option>
                               <option value="con">Con</option>
                               <option value="sin">Sin</option>
                            </select>
                            <label for="floatingSelect">Sitio Web</label>
                        </div>
                    </div>
                </div>
                <!--./form-group row 3-->

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control" v-model="criterio">
                                <option value="nombre_unidad">Unidad</option>
                                <option value="codigo_postal">CP</option>
                                <option value="nombre_vialidad">Calle</option>
                            </select>
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar">
                        </div>
                    </div>
                    <div class="col-md-6">

                        <button type="submit" @click="loadDirectory(1,buscar,criterio,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web)" class="btn btn-info float-end px-4"><i class="bi bi-search"></i> Filtrar</button>

                    </div>
                </div>
                <!--./form-group row 4-->
                <div class="container-fluid overflow-scroll">
                    <h3>Resultados: {{ pagination.total }}</h3>
                    <button type="button" @click="exportar(buscar,criterio,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web)" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Exportar</button>
                    <br><br>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#id_denue</th>
                                <th>clee</th>
                                <th>nombre_unidad</th>
                                <th>razon_social</th>
                                <th>codigo_scian</th>
                                <th>nombre_clase_actividad</th>
                                <th>descripcion_estrato_personal_ocupado</th>
                                <th>tipo_vialidad</th>
                                <th>nombre_vialidad</th>
                                <th>tipo_entre_vialidad_1</th>
                                <th>nombre_entre_vialidad_1</th>
                                <th>tipo_entre_vialidad_2</th>
                                <th>nombre_entre_vialidad_2</th>
                                <th>tipo_entre_vialidad_3</th>
                                <th>nombre_entre_vialidad_3</th>
                                <th>numero_exterior_o_kilometro</th>
                                <th>letra_exterior</th>
                                <th>edificio</th>
                                <th>edificio_piso</th>
                                <th>numero_interior</th>
                                <th>letra_interior</th>
                                <th>tipo_asentamiento_humano</th>
                                <th>nombre_asentamiento_humano</th>
                                <th>tipo_centro_comercial</th>
                                <th>corredor_industrial_comercial_mercado</th>
                                <th>numero_local</th>
                                <th>codigo_postal</th>
                                <th>clave_entidad</th>
                                <th>entidad_federativa</th>
                                <th>clave_municipio</th>
                                <th>municipio</th>
                                <th>clave_localidad</th>
                                <th>localidad</th>
                                <th>area_geoestadistica</th>
                                <th>manzana</th>
                                <th>numero_telefono</th>
                                <th>correo_electronico</th>
                                <th>sitio_internet</th>
                                <th>tipo_establecimiento</th>
                                <th>latitud</th>
                                <th>longitud</th>
                                <th>fecha_incorporacion_denue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="directory in arrayDirectories" :key="directory.id">
                                <td>
                                    <a class="btn btn-primary" target="_blank" :href="'https://google.com/maps?q='+directory.latitud+','+directory.longitud">
                                        <i class="bi bi-geo-alt"> </i> Abrir
                                    </a>
                                </td>
                                <td v-text="directory.id_denue"></td>
                                <td v-text="directory.clee"></td>
                                <td v-text="directory.nombre_unidad"></td>
                                <td v-text="directory.razon_social"></td>
                                <td v-text="directory.codigo_scian"></td>
                                <td v-text="directory.nombre_clase_actividad"></td>
                                <td v-text="directory.descripcion_estrato_personal_ocupado"></td>
                                <td v-text="directory.tipo_vialidad"></td>
                                <td v-text="directory.nombre_vialidad"></td>
                                <td v-text="directory.tipo_entre_vialidad_1"></td>
                                <td v-text="directory.nombre_entre_vialidad_1"></td>
                                <td v-text="directory.tipo_entre_vialidad_2"></td>
                                <td v-text="directory.nombre_entre_vialidad_2"></td>
                                <td v-text="directory.tipo_entre_vialidad_3"></td>
                                <td v-text="directory.nombre_entre_vialidad_3"></td>
                                <td v-text="directory.numero_exterior_o_kilometro"></td>
                                <td v-text="directory.letra_exterior"></td>
                                <td v-text="directory.edificio"></td>
                                <td v-text="directory.edificio_piso"></td>
                                <td v-text="directory.numero_interior"></td>
                                <td v-text="directory.letra_interior"></td>
                                <td v-text="directory.tipo_asentamiento_humano"></td>
                                <td v-text="directory.nombre_asentamiento_humano"></td>
                                <td v-text="directory.tipo_centro_comercial"></td>
                                <td v-text="directory.corredor_industrial_comercial_mercado"></td>
                                <td v-text="directory.numero_local"></td>
                                <td v-text="directory.codigo_postal"></td>
                                <td v-text="directory.clave_entidad"></td>
                                <td v-text="directory.entidad_federativa"></td>
                                <td v-text="directory.clave_municipio"></td>
                                <td v-text="directory.municipio"></td>
                                <td v-text="directory.clave_localidad"></td>
                                <td v-text="directory.localidad"></td>
                                <td v-text="directory.area_geoestadistica"></td>
                                <td v-text="directory.manzana"></td>
                                <td v-text="directory.numero_telefono"></td>
                                <td v-text="directory.correo_electronico"></td>
                                <td v-text="directory.sitio_internet"></td>
                                <td v-text="directory.tipo_establecimiento"></td>
                                <td v-text="directory.latitud"></td>
                                <td v-text="directory.longitud"></td>
                                <td v-text="directory.fecha_incorporacion_denue"></td>
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

                            <!-- AGREGAR LOS CAMPOS A AGREGAR -->
                            <div class="form-group">
                                <label for="name"><strong class="text text-danger">*</strong>Calle</label>
                                <input type="text" class="form-control" v-model="nombre_vialidad" required>
                            </div>

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
              arrayDirectories:[],
              arrayActividades:[],
              arrayLocalidades:[],
              pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },
              actividad_key:0,
              filtro_localidad:'TODOS',
              filtro_tam_est:0,
              filtro_tipo_asentamiento:'TODOS',
              filtro_incorporacion:'TODOS',
              offset:3,
              criterio:'nombre_unidad',
              buscar:'',
              filtro_telefono:'TODOS',
              filtro_email:'TODOS',
              filtro_pagina_web:'TODOS',

              directory_id:0,
              nombre_vialidad:'',



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
            loadDirectory(page,buscar,criterio,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web){
                let me=this;
                var url = '/directorio/get?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&actividad_key='+actividad_key+'&filtro_tam_est='+filtro_tam_est+'&filtro_tipo_asentamiento='+filtro_tipo_asentamiento+'&filtro_localidad='+filtro_localidad+'&filtro_incorporacion='+filtro_incorporacion+'&filtro_telefono='+filtro_telefono+'&filtro_email='+filtro_email+'&filtro_pagina_web='+filtro_pagina_web;
                console.log(url);
                axios.get(url).then(function (response){
                    console.log(response)
                    let respuesta = response.data;
                    me.arrayDirectories = respuesta.directories.data;
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
            cambiarPagina(page,buscar,criterio,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web){
                let me = this;
                me.pagination.current_page = page;
                me.loadDirectory(page,buscar,criterio,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web);
            },
            validarDatos(){
                this.error=0;
                this.errorMostrarMsj=[];
                if(!this.nombre_vialidad) this.errorMostrarMsj.push('La calle de la actividad no puede estar vacio.');
                if(this.errorMostrarMsj.length) this.error=1;
                return this.error;
            },
            registrar(){
                if(this.validarDatos()){
                    return;
                }
                let me=this;
                axios.post('/directorio/store',{
                  'nombre_vialidad': me.nombre_vialidad,
                }).then(function (response){
                  //console.log(response)
                  me.cerrarModal();
                  me.loadDirectory(me.pagination.current_page,me.buscar,me.criterio,me.actividad_key,me.filtro_tam_est,me.filtro_tipo_asentamiento,me.filtro_localidad,me.filtro_incorporacion,me.filtro_telefono,me.filtro_email,me.filtro_pagina_web)
                }).catch(function (error){
                    console.log(error);
                });
            },
            actualizarDatos(){
                if(this.validarDatos('actualizar')){
                    return;
                }
                let me=this;
                axios.put('/directorio/update',{
                  'id':me.directory_id,
                  'nombre_vialidad': me.nombre_vialidad,
                }).then(function (response){
                  //console.log(response)
                  me.cerrarModal();
                  me.loadDirectory(me.pagination.current_page,me.buscar,me.criterio, me.actividad_key,me.filtro_tam_est,me.filtro_tipo_asentamiento,me.filtro_localidad,me.filtro_incorporacion,me.filtro_telefono,me.filtro_email,me.filtro_pagina_web)
                }).catch(function (error){
                    console.log(error);
                });
            },

            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "directorio":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Agregar';
                                this.active=0;
                                this.key='';
                                this.nombre_vialidad='';
                                break;
                            }
                            case 'actualizar_datos':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar';
                                this.directory_id= data['id'];
                                this.nombre_vialidad= data['nombre_vialidad'];
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
            loadAllActividades(){
                let me=this;
                var url = '/actividades/all/get';
                axios.get(url).then(function (response){
                    //console.log(response)
                    me.arrayActividades = response.data;
                    //console.log(me.arrayActividades);
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },

            loadAllLocaliades(){
                let me=this;
                var url = '/localidades/all/get';
                axios.get(url).then(function (response){
                    console.log(response)
                    me.arrayLocalidades = response.data;
                    console.log(me.arrayLocalidades);
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            exportar(buscar,criterio,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web){
                let me=this;
                var url = 'directory/export?buscar='+buscar+'&criterio='+criterio+'&actividad_key='+actividad_key+'&filtro_tam_est='+filtro_tam_est+'&filtro_tipo_asentamiento='+filtro_tipo_asentamiento+'&filtro_localidad='+filtro_localidad+'&filtro_incorporacion='+filtro_incorporacion+'&filtro_telefono='+filtro_telefono+'&filtro_email='+filtro_email+'&filtro_pagina_web='+filtro_pagina_web;
                console.log('Exportar:'+url);
                window.open(url);
            }
        },
        mounted() {
            this.loadDirectory(1,'','nombre_unidad',0,0,'TODOS','TODOS','TODOS','TODOS','TODOS','TODOS');
            this.loadAllActividades();
            this.loadAllLocaliades();
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
