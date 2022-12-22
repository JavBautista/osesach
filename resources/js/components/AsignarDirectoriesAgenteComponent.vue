<template>
<div>
    <div class="container-fluid">
        <!--Card 2-->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> ASIGNARA A {{agente.name}}
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="actividad_key">
                                <option value="0">TODOS</option>
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
                            <select class="form-select" id="floatingSelect" v-model="filtro_incorporacion">
                                <option value="TODOS">TODOS</option>
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
                <!--./form-group row 1-->

                <div class="form-group row">
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
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_nombre_asentamiento">
                                <option value="TODOS">TODOS</option>
                                <option v-for="ast in arrayAsentamientos" :key="ast.id" :value="ast.description" v-text="ast.description"></option>
                            </select>
                            <label for="floatingSelect">Asentamiento</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_localidad">
                                <option value="TODOS">TODOS</option>
                                <option v-for="loc in arrayLocalidades" :key="loc.id" :value="loc.description" v-text="loc.description"></option>
                            </select>
                            <label for="floatingSelect">Localidad</label>
                        </div>
                    </div>


                </div>
                <!--./form-group row 2-->

                <div class="form-group row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_telefono">
                                <option value="TODOS">TODOS</option>
                                <option value="con">Con</option>
                                <option value="sin">Sin</option>

                            </select>
                            <label for="floatingSelect">Teléfono</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_email">
                                <option value="TODOS">TODOS</option>
                                <option value="con">Con</option>
                                <option value="sin">Sin</option>
                            </select>
                            <label for="floatingSelect">Email</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" v-model="filtro_pagina_web">
                               <option value="TODOS">TODOS</option>
                               <option value="con">Con</option>
                               <option value="sin">Sin</option>
                            </select>
                            <label for="floatingSelect">Sitio Web</label>
                        </div>
                    </div>
                </div>
                <!--./form-group row 3-->
                <div class="form-group row">
                    <div class="col-md-3">
                        <div class="input-group">
                            <label for="num_registros">#Registros</label>
                            <select class="form-control" v-model="num_registros">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                    <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="localidad">Localidad</option>
                                <option value="nombre_asentamiento_humano">Asentamiento</option>
                                <option value="codigo_postal">CP</option>
                                <option value="nombre_unidad">Unidad</option>
                            </select>
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadDirectories(1,buscar,criterio,num_registros,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web,filtro_nombre_asentamiento)">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <button type="submit" @click="loadDirectories(1,buscar,criterio,num_registros,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web,filtro_nombre_asentamiento)" class="btn btn-lg btn-info px-4"><i class="bi bi-search"></i> Filtrar</button>
                    </div>

                </div>


                <!--./form-group row 4-->
                <div class="container" style="overflow: hidden">
                    <div class="form-group row">
                        <div class="col-md-6"><h3>Resultados: {{ pagination.total }}</h3></div>
                        <div class="col-md-6">
                            <button class="btn float-end btn-success my-2" @click="asignarRegistros()"> <i class="bi bi-plus"></i>  Asignar Registros</button>
                        </div>
                    </div>



                    <table class="table  table-responsive table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>#id_denue</th>
                                <th>clee</th>
                                <th>nombre_unidad</th>
                                <th>nombre_asentamiento_humano</th>
                                <th>codigo_postal</th>
                                <th>localidad</th>
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
                            <tr v-for="dir in arrayDirectories" :key="dir.id">
                                <td> <button class="btn btn-info" @click="asignarPorRegistro(dir.id)"> <i class="icon icon-plus"></i> </button> </td>
                                <td>{{dir.id}}</td>
                                <td>{{dir.id_denue}}</td>
                                <td>{{dir.clee}}</td>
                                <td>{{dir.nombre_unidad}}</td>
                                <td>{{dir.nombre_asentamiento_humano}}</td>
                                <td>{{dir.codigo_postal}}</td>
                                <td>{{dir.localidad}}</td>
                                <td>{{dir.razon_social}}</td>
                                <td>{{dir.codigo_scian}}</td>
                                <td>{{dir.nombre_clase_actividad}}</td>
                                <td>{{dir.descripcion_estrato_personal_ocupado}}</td>
                                <td>{{dir.tipo_vialidad}}</td>
                                <td>{{dir.nombre_vialidad}}</td>
                                <td>{{dir.tipo_entre_vialidad_1}}</td>
                                <td>{{dir.nombre_entre_vialidad_1}}</td>
                                <td>{{dir.tipo_entre_vialidad_2}}</td>
                                <td>{{dir.nombre_entre_vialidad_2}}</td>
                                <td>{{dir.tipo_entre_vialidad_3}}</td>
                                <td>{{dir.nombre_entre_vialidad_3}}</td>
                                <td>{{dir.numero_exterior_o_kilometro}}</td>
                                <td>{{dir.letra_exterior}}</td>
                                <td>{{dir.edificio}}</td>
                                <td>{{dir.edificio_piso}}</td>
                                <td>{{dir.numero_interior}}</td>
                                <td>{{dir.letra_interior}}</td>
                                <td>{{dir.tipo_asentamiento_humano}}</td>
                                <td>{{dir.nombre_asentamiento_humano}}</td>
                                <td>{{dir.tipo_centro_comercial}}</td>
                                <td>{{dir.corredor_industrial_comercial_mercado}}</td>
                                <td>{{dir.numero_local}}</td>
                                <td>{{dir.codigo_postal}}</td>
                                <td>{{dir.clave_entidad}}</td>
                                <td>{{dir.entidad_federativa}}</td>
                                <td>{{dir.clave_municipio}}</td>
                                <td>{{dir.municipio}}</td>
                                <td>{{dir.clave_localidad}}</td>
                                <td>{{dir.localidad}}</td>
                                <td>{{dir.area_geoestadistica}}</td>
                                <td>{{dir.manzana}}</td>
                                <td>{{dir.numero_telefono}}</td>
                                <td>{{dir.correo_electronico}}</td>
                                <td>{{dir.sitio_internet}}</td>
                                <td>{{dir.tipo_establecimiento}}</td>
                                <td>{{dir.latitud}}</td>
                                <td>{{dir.longitud}}</td>
                                <td>{{dir.fecha_incorporacion_denue}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio,num_registros,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web,filtro_nombre_asentamiento)">Ant</a>
                        </li>

                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,num_registros,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web,filtro_nombre_asentamiento)" v-text="page"></a>
                        </li>

                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio,num_registros,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web,filtro_nombre_asentamiento)">Sig</a>
                        </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!--./Card 2-->
    </div>
</div>
</template>

<script>
    export default {
        props: ['agente'],
        data(){
            return {
              arrayActividades:[],
              arrayLocalidades:[],
              arrayAsentamientos:[],
              arrayDirectories:[],
              arrayAgentes:[],

              pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },

              offset:3,
              criterio:'nombre_unidad',
              buscar:'',

              num_registros:10,
              actividad_key:0,
              filtro_localidad:'TODOS',
              filtro_tam_est:0,
              filtro_tipo_asentamiento:'TODOS',
              filtro_nombre_asentamiento:'TODOS',
              filtro_incorporacion:'TODOS',
              filtro_telefono:'TODOS',
              filtro_email:'TODOS',
              filtro_pagina_web:'TODOS',

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
            cambiarPagina(page,buscar,criterio,num_registros,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web,filtro_nombre_asentamiento){
                let me = this;
                me.pagination.current_page = page;
                me.loadDirectories(page,buscar,criterio,num_registros,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web,filtro_nombre_asentamiento);
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
            loadAllAsentamientos(){
                let me=this;
                var url = '/asentamientos/all/get';
                axios.get(url).then(function (response){
                    console.log('GET ASENT')
                    //console.log(response)
                    me.arrayAsentamientos = response.data;
                    console.log(me.arrayAsentamientos);
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },

            loadDirectories(page,buscar,criterio,num_registros,actividad_key,filtro_tam_est,filtro_tipo_asentamiento,filtro_localidad,filtro_incorporacion,filtro_telefono,filtro_email,filtro_pagina_web,filtro_nombre_asentamiento){
                let me=this;
                var url = '/directorio/get-directories-assign?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&num_registros='+num_registros+'&actividad_key='+actividad_key+'&filtro_tam_est='+filtro_tam_est+'&filtro_tipo_asentamiento='+filtro_tipo_asentamiento+'&filtro_localidad='+filtro_localidad+'&filtro_incorporacion='+filtro_incorporacion+'&filtro_telefono='+filtro_telefono+'&filtro_email='+filtro_email+'&filtro_pagina_web='+filtro_pagina_web+'&filtro_nombre_asentamiento='+filtro_nombre_asentamiento;
                console.log(url);
                axios.get(url).then(function (response){
                    console.log(response)
                    let respuesta = response.data;
                    me.arrayDirectories = respuesta.directories.data;
                    me.pagination = respuesta.pagination;
                    console.log(me.arrayDirectories);
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            }, //.loadDirectories()
            asignarRegistros(){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea asignar los resgistros?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                    let me=this;
                    axios.put('/asignar/update/asignar-registros',{
                        'agente_id':me.agente.id,
                        'buscar':me.buscar,
                        'criterio':me.criterio,
                        'num_registros':me.num_registros
                    }).then(function (response){
                        console.log('reponse:')
                        console.log(response)
                        me.loadDirectories(1,me.buscar,me.criterio,me.num_registros,me.actividad_key,me.filtro_tam_est,me.filtro_tipo_asentamiento,me.filtro_localidad,me.filtro_incorporacion,me.filtro_telefono,me.filtro_email,me.filtro_pagina_web,me.filtro_nombre_asentamiento);
                        swalWithBootstrapButtons.fire(
                          'OK',
                          'Registros asignados.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });
                  }
                })
            },//.asignar()
            asignarPorRegistro(directory_id){

                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea asignar este unico resgistro?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                    let me=this;
                    axios.put('/asignar/update/asignar-por-registro',{
                        'agente_id':me.agente.id,
                        'directory_id':directory_id,
                    }).then(function (response){
                        console.log('reponse:')
                        console.log(response)
                        me.loadDirectories(1,me.buscar,me.criterio,me.num_registros,me.actividad_key,me.filtro_tam_est,me.filtro_tipo_asentamiento,me.filtro_localidad,me.filtro_incorporacion,me.filtro_telefono,me.filtro_email,me.filtro_pagina_web,me.filtro_nombre_asentamiento);
                        swalWithBootstrapButtons.fire(
                          'OK',
                          'Registro asignado.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });
                  }
                })
            }//.asignarPorRegistro()
        },
        mounted() {
            console.log('AsigDirecAgente Component mounted.')
            if(this.agente){
                console.log(this.agente)
                this.loadAllActividades();
                this.loadAllLocaliades();
                this.loadAllAsentamientos();
                this.loadDirectories(1,this.buscar,this.criterio, this.num_registros,0,0,'TODOS','TODOS','TODOS','TODOS','TODOS','TODOS','TODOS')
            }
        }
    }
</script>
