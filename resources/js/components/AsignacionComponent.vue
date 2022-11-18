<template>
<div>
    <div class="container-fluid">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <i class="fa fa-align-justify"></i> AGENTES
              </button>
            </h2>
            <div id="collapseOne" :class="a_show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">

                        <div class="form-group row">
                            <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="description">Descripción</option>
                                </select>
                                <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadAgentes(1,buscar,criterio)">
                                <button type="submit" @click="loadAgentes(1,buscar,criterio)" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                            </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Direccion</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Fecha ingreso</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="persona in arrayAgentes" :key="persona.id">
                                        <td v-text="persona.name"></td>
                                        <td v-text="persona.address"></td>
                                        <td v-text="persona.movil"></td>
                                        <td v-text="persona.email"></td>
                                        <td v-text="persona.date_admission"></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" @click="opcion(persona,'asignar')" title="Activar"> <i class="fa fa-plus"></i></button>
                                            <button type="button" class="btn btn-info" @click="opcion(persona,'asignacion')" title="Activar"> <i class="fa fa-search"></i></button>
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
          </div>
          </div>
        </div>

        <template v-if="agente_id>0">
            <div class="container">
                <button class="btn btn-outline-secondary" @click="cerrarOpciones()"><i class="fa fa-close"></i>Cerrar</button>
            </div>
            <div class="container">
            <asignar-directories-agente-component v-if="show_asignar" :agente="agente"></asignar-directories-agente-component>

            <agente-directories-component v-if="show_asignacion" :agente="agente"></agente-directories-component>
            </div>
        </template>
    </div>
</div>
</template>

<script>
    import MiTest from './MiTest.vue';
    export default {
        components: {
            'test-component': MiTest
        },
        data(){
            return {
              arrayAgentes:[],
              agente_id:0,
              agente:[],
              a_show:'accordion-collapse show',
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

              show_asignar:0,
              show_asignacion:0,
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

            loadAgentes(page,buscar,criterio){
                let me=this;
                var url = '/personal/agentes/get?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response){
                    console.log(response)
                    let respuesta = response.data;
                    me.arrayAgentes = respuesta.agents.data;
                    me.pagination = respuesta.pagination;
                    console.log(me.arrayAgentes);
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
                me.loadAgentes(page,buscar,criterio);
            },

            opcion(data=[],accion){
                this.agente_id= data['id'];
                this.agente= data;
                this.a_show='accordion-collapse hide collapse';

                switch(accion){
                    case 'asignar':{
                        this.show_asignar=1;
                        this.show_asignacion=0;
                        break;
                    }
                    case 'asignacion':{
                        this.show_asignar=0;
                        this.show_asignacion=1;
                        break;
                    }
                }



            },
            cerrarOpciones(){
                this.agente_id=0;
                this.show_asignar=0;
                this.show_asignacion=0;
            }
        },
        mounted() {
            this.loadAgentes(1,'','description');
        }
    }
</script>
