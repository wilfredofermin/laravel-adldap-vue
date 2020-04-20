<template >
  <div row mt-4>
    <div class="container-fluid">
      <!-- AQUI LOS WIDGETS -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info">
              <i class="fas fa-folder-open"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Messages</span>
              <span class="info-box-number">1,410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-success">
              <i class="fas fa-flag"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Bookmarks</span>
              <span class="info-box-number">410</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-warning">
              <i class="fas fa-copy"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Uploads</span>
              <span class="info-box-number">13,648</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-danger">
              <i class="fas fa-star"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Likes</span>
              <span class="info-box-number">93,139</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

      <!-- FIN WIDGET -->
      <div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">SOLICITUDES</h3>
            <div class="card-tools">
              <!-- <button type="button" @click="MostrarModal()" class="btn btn-primary btn-sm">
                <i class="fa fa-user-plus" aria-hidden="true"></i> Ingreso
              </button>-->

              <div class="dropdown">
                <button
                  class="btn btn-primary dropdown-toggle"
                  type="button"
                  id="dropdownMenu2"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >Solicitud</button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <button
                    class="dropdown-item btn-sm btn-block"
                    type="button"
                    @click="modalIngreso()"
                  >
                    <i class="fa fa-user-plus text-center" aria-hidden="true"></i> Nuevo Ingreso
                  </button>
                  <button
                    class="dropdown-item btn-sm btn-block"
                    type="button"
                    @click="MostrarModal()"
                  >
                    <i class="fa fa-user-times text-center" aria-hidden="true"></i> Desahucio
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-tool"></div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th width="5%">ServicesKit</th>
                  <th width="5%">Tipo</th>
                  <th width="20%">Nombres</th>
                  <th width="15%">Puesto</th>
                  <th width="5%">Estado</th>
                  <th width="15%">Creacion</th>
                  <th width="15%">Modificacion</th>
                  <th width="5%">Prioridad</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="solicitud in db_solicitudes"
                  :key="solicitud.id "
                  @click="modalInfo(solicitud)"
                >
                  <td>{{ solicitud.serviceskit }}</td>

                  <td v-if="solicitud.tipo ==1">
                    <button type="button" class="btn btn-outline-success btn-sm btn-block">Ingreso</button>
                  </td>
                  <td v-else-if="solicitud.tipo ==2">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-block">Desahucio</button>
                  </td>
                  <td v-else>
                    <button
                      type="button"
                      class="btn btn-outline-primary btn-sm btn-block"
                    >Modificacion</button>
                  </td>
                  <td>{{ solicitud.nombres | capitalize }} {{solicitud.apellidos | capitalize }}</td>
                  <td>{{ solicitud.puesto | capitalize }}</td>
                  <td v-if="solicitud.estado=='Abierto'">
                    <toggle-button
                      :value="true"
                      color="#99CF16"
                      :sync="true"
                      :labels="true"
                      disabled
                    />
                  </td>
                  <td v-else>
                    <toggle-button
                      :value="false"
                      color="#99CF16"
                      :sync="true"
                      :labels="true"
                      disabled
                    />
                  </td>

                  <td>{{ solicitud.created_at | fechas }}</td>
                  <td>{{ solicitud.created_at | fechas }}</td>

                  <td v-if="solicitud.Prioridad =='normal'">
                    <button type="button" class="btn btn-outline-primary btn-sm btn-block">Normal</button>
                  </td>
                  <td v-else-if="solicitud.Prioridad =='baja'">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-block">Alta</button>
                  </td>
                  <td v-else>
                    <button type="button" class="btn btn-outline-success btn-sm btn-block">Baja</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- MODAL NUEVO INGRESO -->
      <form @submit.prevent="postIngreso()">
        <div
          class="modal fade"
          id="addnew"
          tabindex="-1"
          role="dialog"
          aria-labelledby="addnew"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered modal-lg cl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addnew">NUEVO INGRESO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- CEDULA -->
                <div class="card card-header">
                  <div class="row">
                    <div class="div col-3">
                      <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-fingerprint"></i>
                            </span>
                          </div>
                          <input
                            v-model="form.cedula"
                            outlined
                            type="text"
                            name="cedula"
                            placeholder="cedula"
                            ref="cedula"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            pattern="\d*"
                            maxlength="11"
                            id="cedula"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('cedula') }"
                          />
                          <has-error :form="form" field="cedula"></has-error>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- -------------------------------------------------------------------------------------------------- -->
                  <!-- PRIMER NOMBRE -->
                  <div class="row">
                    <div class="col-md-10">
                      <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-user"></i>
                            </span>
                          </div>
                          <input
                            v-model="form.primer_nombre"
                            type="text"
                            name="primer_nombre"
                            placeholder="Primer Nombre"
                            ref="primer_nombre"
                            id="primer_nombre"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('primer_nombre') }"
                          />
                          <has-error :form="form" field="primer_nombre"></has-error>
                        </div>
                      </div>
                    </div>
                    <!-- SEGUNDO NOMBRE -->
                    <div class="col-md-2">
                      <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-user"></i>
                            </span>
                          </div>
                          <input
                            v-model="form.segundo_nombre"
                            type="text"
                            name="segundo_nombre"
                            placeholder="SN"
                            ref="segundo_nombre"
                            pattern="\d*"
                            maxlength="1"
                            id="segundo_nombre"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('segundo_nombre') }"
                          />
                          <has-error :form="form" field="segundo_nombre"></has-error>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- -------------------------------------------------------------------------------------------------- -->
                  <!-- PRIMER APELLIDO -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-user-tag"></i>
                            </span>
                          </div>
                          <input
                            v-model="form.primer_apellido"
                            type="text"
                            name="primer_apellido"
                            placeholder="Primer Apellido"
                            ref="primer_apellido"
                            id="primer_apellido"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('primer_apellido') }"
                          />
                          <has-error :form="form" field="primer_apellido"></has-error>
                        </div>
                      </div>
                    </div>
                    <!-- SEGUNDO APELLIDO -->
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-user-tag"></i>
                            </span>
                          </div>
                          <input
                            v-model="form.segundo_apellido"
                            type="text"
                            name="segundo_apellido"
                            placeholder="Segundo Nombre | opcional"
                            text-transform:
                            lowercase
                            ref="segundo_apellido"
                            id="segundo_apellido"
                            autofocus
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('segundo_apellido') }"
                          />
                          <has-error :form="form" field="segundo_apellido"></has-error>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- -------------------------------------------------------------------------------------------------- -->
                <!-- DEPARTAMENTO -->
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <select
                        @change.prevent="getPuestos()"
                        name="departamento"
                        v-model="form.departamento"
                        id="departamento"
                        class="form-control"
                        :class="{ 'is-invalid':form.errors.has('departamento')}"
                      >
                        <option value selected disabled hidden>Departamento</option>
                        <option
                          v-for="departamento in data_departamentos"
                          :value="departamento.id"
                          :key="departamento.id"
                        >{{ departamento.nombre }}</option>
                      </select>
                      <has-error :form="form" field="departamento"></has-error>
                    </div>
                  </div>
                  <!-- PUESTO -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <select
                        @change="getLocalidad()"
                        name="puesto"
                        v-model="form.puesto"
                        id="puesto"
                        class="form-control"
                        :class="{ 'is-invalid':form.errors.has('puesto')}"
                      >
                        <option value selected disabled hidden>Puesto</option>
                        <option
                          v-for="puestoArray in data_puestos"
                          :key="puestoArray.id"
                        >{{ puestoArray.nombre }}</option>
                      </select>
                      <has-error :form="form" field="puesto"></has-error>
                    </div>
                  </div>
                  <!-- LOCALIDAD -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <select
                        name="localidad"
                        @change="ActivarSupervisor()"
                        v-model="form.localidad"
                        id="localidad"
                        class="form-control"
                        :class="{ 'is-invalid':form.errors.has('localidad')}"
                      >
                        <option value selected disabled hidden>Localidad</option>
                        <option v-for="loc in data_localidad" :key="loc.id">{{ loc.nombre }}</option>
                      </select>
                      <has-error :form="form" field="localidad"></has-error>
                    </div>
                  </div>
                  <!-- -------------------------------------------------------------------------------------------------- -->
                  <!-- SUPERVISOR-->
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                          </span>
                        </div>
                        <input
                          v-model="form.supervisor"
                          type="email"
                          name="supervisor"
                          id="supervisor"
                          class="form-control"
                          placeholder="Correo Electronico de Supervisor"
                          :class="{ 'is-invalid': form.errors.has('supervisor') }"
                        />
                        <has-error :form="form" field="supervisor"></has-error>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Enviar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <!-- fin modal -->
      <!-- MODAL INFO -->
      <div class="modal fade" id="modalInfo">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detalles de la solicitud</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-user"></i>
                        </span>
                      </div>
                      <input
                        type="text"
                        v-model="nombre_completo"
                        name="nombre_completo"
                        readonly
                        ref="nombre_completo"
                        id="nombre_completo"
                        class="form-control"
                      />
                    </div>
                  </div>
                  <!-- CEDULA -->
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-user"></i>
                        </span>
                      </div>
                      <input
                        type="text"
                        v-model="cedula_info"
                        name="cedula_info"
                        readonly
                        ref="cedula_info"
                        id="cedula_info"
                        class="form-control"
                      />
                    </div>
                  </div>
                  <!-- SUPERVISOR -->
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="fas fa-user"></i>
                        </span>
                      </div>
                      <input
                        type="text"
                        v-model="supervisor_info"
                        name="supervisor_info"
                        readonly
                        ref="supervisor_info"
                        id="supervisor_info"
                        class="form-control"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- MODAL DESHAUCIO-MODIFICACION -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activo: false,
      //   dynamicValue: false,
      db_solicitudes: {},
      db_infosolicitud: {},
      data_departamentos: [],
      data_puestos: [],
      data_localidad: [],
      nombre_completo: "",
      cedula_info: "",
      supervisor_info: "",
      form: new Form({
        cedula: "",
        primer_nombre: "",
        segundo_nombre: "",
        primer_apellido: "",
        segundo_apellido: "",
        departamento: "",
        puesto: "",
        localidad: "",
        supervisor: ""
      })
    };
  },
  methods: {
    // VENTANA MODAL
    modalIngreso: function() {
      this.form.reset();
      $("#addnew").modal("show");
    },

    postIngreso() {
      // 1- Cargo el progress bar
      this.$Progress.start();
      this.form
        .post("/postIngreso")
        //DE TODO ESTAR CORRECTO ----> video tutorail : https://www.youtube.com/watch?v=97JFc7g_0wE&list=PL2GMR7k4bG4QOzLtn4WgMmLAjfKiAvRa1&index=22
        .then(() => {
          // Submit the form via a POST request
          // 2- Hago la peticion de la data
          //3- Recargo los datos
          Fire.$emit("RecargarData");
          //4- Cierro la ventana modal
          $("#addnew").modal("hide");
          //5- Cargo la barra como finalizado por proceso
          this.$Progress.finish();
          //6- Hago la notificacion
          toast.fire({
            type: "success",
            title: "Usuario creado exitosamente"
          });
        })
        //DE LO CONTRARIO
        .catch(() => {
          this.$Progress.fail();
        });
    },
    // VENTANA MODAL
    modalInfo: function(solicitud) {
      $("#modalInfo").modal("show");
      axios.get("/infoSolicitud/" + solicitud.id).then(response => {
        this.nombre_completo =
          response.data.nombres + " " + response.data.apellidos;

        this.cedula_info = response.data.cedula;
        this.supervisor_info = response.data.supervisor_email;
      });
    },

    getSolicitudes() {
      axios.get("/getSolicitudes").then(response => {
        this.db_solicitudes = response.data;
      });
    },
    getDepartamentos() {
      axios.get("/getDepartamentos").then(response => {
        this.data_departamentos = response.data;
      });
    },
    getPuestos() {
      this.form.puesto = "";

      if (this.form.departamento != "") {
        axios
          .get("/getPuestos", {
            params: { departamento_id: this.form.departamento }
          })
          .then(response => {
            this.data_puestos = response.data;
            document.getElementById("puesto").disabled = false;
          })
          .catch(e => {
            console.log(e);
          });
      }
    },
    ActivarSupervisor() {
      document.getElementById("supervisor").disabled = false;
    },
    getLocalidad() {
      this.form.localidad = "";
      axios.get("/getLocalidad").then(response => {
        this.data_localidad = response.data;
        document.getElementById("localidad").disabled = false;
      });
    }
  },
  created() {
    this.$Progress.start();
    this.getSolicitudes();
    this.getDepartamentos();

    Fire.$on("RecargarData", () => {
      this.getSolicitudes();
    });

    this.$Progress.finish();
  },

  mounted() {
    document.getElementById("puesto").disabled = true;
    document.getElementById("localidad").disabled = true;
    document.getElementById("supervisor").disabled = true;
  }
};
</script>