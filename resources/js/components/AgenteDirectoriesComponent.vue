<template>
<div>
    <div class="container-fluid">
        <!--Card 2-->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> ASIGNACION DE {{agente.name}}
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="localidad">Localidad</option>
                                <option value="nombre_asentamiento_humano">Asentamiento</option>
                                <option value="codigo_postal">CP</option>
                                <option value="nombre_unidad">Unidad</option>
                            </select>
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadDirectories(1,buscar,criterio)">
                            <button type="submit" @click="loadDirectories(1,buscar,criterio)" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="container" style="overflow: hidden">
                    <button class="btn btn-warning my-2" @click="desasignarRegistros()">+ Desasignar Registros</button>
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
                                <td> <button class="btn btn-warning"> <i class="icon icon-minus"></i> </button> </td>
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
              arrayDirectories:[],
              criterio:'localidad',
              buscar:'',
            }
        },

        methods:{
            loadDirectories(page,buscar,criterio,){
                let me=this;
                let agente_id= me.agente.id;
                var url = '/directorio/get-directories-agente?agente_id='+agente_id+'&page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response){
                    console.log(response)
                    me.arrayDirectories = response.data;
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
            desasignarRegistros(){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea desasignar los resgistros?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {
                    let me=this;
                    axios.put('/asignar/update/desasignar-registros',{
                        'agente_id':me.agente.id
                    }).then(function (response){
                        console.log('reponse:')
                        console.log(response)
                        me.loadDirectories(1,me.buscar,me.criterio);
                        swalWithBootstrapButtons.fire(
                          'OK',
                          'Registros desasignados.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });
                  }
                })
            }//.asignar()
        },
        mounted() {
            console.log('Asignacion agente Component mounted.')
            if(this.agente){
                console.log(this.agente)
                this.loadDirectories(1,this.buscar,this.criterio)
            }
        }
    }
</script>
