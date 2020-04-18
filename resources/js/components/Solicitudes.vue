
<template>
  <div row mt-4>
    <div class="container-fluid">
      <div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">NUEVOS INGRESOS</h3>
            <div class="card-tools">
              <button type="button" @click="MostrarModal()" class="btn btn-primary">
                <i class="fa fa-user-plus" aria-hidden="true"></i> Agregar
              </button>
            </div>
          </div>
          <div class="card-tool"></div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th width="5%">ServicesKit</th>
                  <th width="5%">Cedula</th>
                  <th width="20%">Nombres</th>
                  <th width="15%">Departamento</th>
                  <th width="15%">Puesto</th>
                  <th width="5%">Estado</th>
                  <th width="5%">Prioridad</th>
                  <th width="15%">Creacion</th>
                  <th width="15%">Modificacion</th>
                  <th width="5%" text-align:center>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="solicitud in db_solicitudes" :key="solicitud.id">
                  <td>{{ solicitud.serviceskit }}</td>
                  <td>{{ solicitud.cedula}}</td>
                  <td>{{ solicitud.nombres}} {{solicitud.apellidos}}</td>
                  <td>{{ solicitud.departamento }}</td>
                  <td>{{ solicitud.puesto }}</td>
                  <td>{{ solicitud.estado }}</td>
                  <td>{{ solicitud.Prioridad }}</td>
                  <td>{{ solicitud.created_at | fechas }}</td>
                  <td pl-4>
                    <a ref="#">
                      <i class="fas fa-ellipsis-v"></i>
                      <button
                        class="btn pmd-btn-raised pmd-ripple-effect btn-success"
                        type="button"
                      >Success</button>
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
      <!-- Modal -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editmode: false,
      db_solicitudes: {},
      // data_departamentos: {},
      // data_puestos: {},
      // data_localidad: {},
      form: new Form({
        cedula: "",
        primer_nombre: "",
        segundo_nombre: "",
        primer_apellido: "",
        segundo_apellido: "",
        select_departamento: "",
        select_puesto: "",
        select_localidad: "",
        supervisor: "",
        remember: true
      })
    };
  },
  methods: {
    // MostrarModal: function() {
    //   this.editmode = false;
    //   this.form.reset();
    //   $("#addnew").modal("show");
    // },
    getSolicitudes() {
      axios.get("/getSolicitudes").then(response => {
        this.db_solicitudes = response.data;
      });
    }
    // getDepartamentos() {
    //   axios.get("/getDepartamentos").then(response => {
    //     this.data_departamentos = response.data;
    //   });
    // },
    // getLocalidad() {
    //   axios.get("/getLocalidad").then(response => {
    //     this.data_localidad = response.data;
    //     document.getElementById("localidad").disabled = false;
    //   });
    // },
    // getPuestos() {
    //   this.form.select_puesto = "";

    //   if (this.form.select_departamento != "") {
    //     axios
    //       .get("/getPuestos", {
    //         params: { departamento_id: this.form.select_departamento }
    //       })
    //       .then(response => {
    //         this.data_puestos = response.data;
    //         document.getElementById("puesto").disabled = false;
    //       })
    //       .catch(e => {
    //         console.log(e);
    //       });
    //   }
    // },
    // getSupervisor() {
    //   console.log(this.form.supervisor);
    // }
  },
  created() {
    this.getSolicitudes();
    // this.getDepartamentos();
    // this.getLocalidad();

    // this.getPuestos();
  },

  mounted() {
    // document.getElementById("puesto").disabled = true;
    // document.getElementById("localidad").disabled = true;
    // console.log("Component mounted.");
    // document.getElementById("puesto").disabled = true;
  }
};
</script>
