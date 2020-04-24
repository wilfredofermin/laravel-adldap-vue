<template >
  <div row mt-4>
    <div class="container-fluid">
      <!-- AQUI LOS WIDGETS -->

      <!-- FIN WIDGET -->
      <!-- TABLA DE CONTENIDO -->
      <div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">SOLICITUDES</h3>
            <div class="card-tools">
              <div class="dropdown">
                <button
                  class="btn btn-primary dropdown-toggle"
                  type="button"
                  id="dropdownMenu2"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="fas fa-exchange-alt"></i> Solicitud
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <!-- AQUI LAS OPCIONES -->
                  <button
                    class="dropdown-item btn-sm btn-block"
                    type="button"
                    @click="modalIngreso()"
                  >
                    <i class="fas fa-arrow-alt-circle-right"></i> Nuevo Ingreso
                  </button>
                  <li class="divider"></li>
                  <button
                    class="dropdown-item btn-sm btn-block"
                    type="button"
                    @click="getEmpleado()"
                  >
                    <i class="fas fa-arrow-alt-circle-left"></i> Salida Empleado
                  </button>
                  <!-- FIN DE LAS OPCIONES -->
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
                  @click="Informacion(solicitud)"
                >
                  <td>{{ solicitud.serviceskit }}</td>

                  <td v-if="solicitud.tipo ==1">
                    <button type="button" class="btn btn-outline-primary btn-sm btn-block">
                      <i class="fas fa-arrow-alt-circle-right"></i> Ingreso
                    </button>
                  </td>
                  <td v-else-if="solicitud.tipo ==2">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-block">
                      <i class="fas fa-arrow-alt-circle-left"></i> Salida
                    </button>
                  </td>
                  <td v-else>
                    <button type="button" class="btn btn-outline-success btn-sm btn-block">
                      <i class="fas fa-arrow-alt-circle-up"></i> Modificacion
                    </button>
                  </td>
                  <td>{{ solicitud.nombre_completo | capitalize }}</td>
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
                  <td v-else-if="solicitud.Prioridad =='alta'">
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
                            <i class="fas fa-eye"></i>
                          </span>
                        </div>
                        <input
                          v-model="form.supervisor"
                          type="text"
                          name="supervisor"
                          id="supervisor"
                          class="form-control"
                          placeholder="El usuario del supervisor"
                          :class="{ 'is-invalid': form.errors.has('supervisor') }"
                        />
                        <has-error :form="form" field="supervisor"></has-error>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-success">
                    <i class="fas fa-check-circle"></i> Enviar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <!-- SALIDA EMPLEADO -->
      <form @submit.prevent="postSalida()">
        <div class="modal fade" id="modal-detalles">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 v-show="salida" class="modal-title">SOLICITUD DE SALIDAD</h4>
                <h4 v-show="!salida" class="modal-title">SOLICITUD DE INGRESO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-md-11">
                      <div v-show="!mostrar_detalles" class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-user"></i>
                          </span>
                        </div>
                        <input
                          placeholder="Por favor, indique el usuario del empleado"
                          type="text"
                          v-show="input_buscar"
                          v-model="buscar_empleado"
                          @keyup.enter="getEmpleado"
                          name="buscar_empleado"
                          ref="buscar_empleado"
                          id="buscar_empleado"
                          class="form-control"
                        />
                        <div class="col-md-1">
                          <button
                            v-show="btn_buscar"
                            type="button"
                            class="btn btn-outline-primary"
                            @click.prevent="getEmpleado"
                          >
                            <i class="fas fa-search"></i> Buscar
                          </button>
                        </div>
                      </div>
                    </div>

                    <!-- Widget: user widget style 2 -->
                    <div v-show="mostrar_detalles" class="card card-widget widget-user-2">
                      <!-- ---------------------------------------------------------------------------------------------------->
                      <!-- CONDICION DEL COLOR DEL MODAL -->
                      <!-- ---------------------------------------------------------------------------------------------------->
                      <div
                        class="widget-user-header"
                        v-bind:class="salida==true ? 'bg-danger':'bg-primary'"
                      >
                        <div class="widget-user-image">
                          <img
                            class="img-circle elevation-2"
                            src="/img/profile/user.png"
                            alt="User Avatar"
                          />
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username">{{empleado_nombre | capitalize}}</h3>
                        <h5 class="widget-user-desc">{{empleado_puesto |capitalize}}</h5>
                      </div>
                      <div class="card-footer p-0">
                        <ul class="nav flex-column">
                          <li class="nav-item">
                            <a href="#" class="nav-link">
                              Usuario
                              <span
                                class="description-text float-right"
                              >{{empleado_usuario | capitalize }}</span>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="#" class="nav-link">
                              Departamento
                              <span
                                class="description-text float-right"
                              >{{empleado_departamento | capitalize}}</span>
                            </a>
                          </li>
                          <li class="nav-item" v-if="empleado_email">
                            <a href="#" class="nav-link">
                              Correo Electronico
                              <span
                                class="description-text float-right"
                              >{{empleado_email | capitalize }}</span>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="#" class="nav-link">
                              Localidad
                              <span
                                class="description-text float-right"
                              >{{empleado_localidad | capitalize}}</span>
                            </a>
                          </li>
                          <li v-if="empleado_supervisor " class="nav-item">
                            <a href="#" class="nav-link">
                              Supervisor
                              <span
                                class="description-text float-right"
                              >{{empleado_supervisor | capitalize}}</span>
                            </a>
                          </li>
                          <li class="nav-item" v-if="solicitante">
                            <a href="#" class="nav-link">
                              Solicitante
                              <span class="description-text float-right">
                                <Button
                                  class="btn btn-block btn-outline-primary btn-sm disabled"
                                  type="button"
                                >{{solicitante | capitalize}}</Button>
                              </span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <!-- /.widget-user -->
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button
                  type="button"
                  v-show="btn_cerrar"
                  class="btn btn-outline-danger"
                  data-dismiss="modal"
                  @click="modalCierre()"
                >
                  <i class="fas fa-times-circle"></i> Cerrar
                </button>
                <button
                  type="button"
                  v-show="btn_procesado"
                  class="btn btn-success btn-block"
                  data-dismiss="modal"
                >
                  <i class="fas fa-clipboard-check"></i> Esta solicitud ha sido procesada
                </button>
                <div>
                  <button
                    v-show="btn_enviar"
                    type="submit"
                    class="btn btn-outline-success"
                    @click.prevent="deleteSalida(empleado_usuario )"
                  >
                    <i class="fas fa-check-circle"></i> Enviar
                  </button>
                  <div v-show="is_admin">
                    <button
                      v-if="tipoSolicitud==1"
                      type="button"
                      v-show="btn_procesar_entrada"
                      class="btn btn-outline-primary"
                    >
                      <i class="fas fa-check-circle"></i> Procesar
                      <strong>Entrada</strong>
                    </button>
                    <button
                      v-else
                      v-show="btn_procesar_salidad"
                      type="button"
                      class="btn btn-outline-danger"
                      @click.prevent="procesarSalida(empleado_id )"
                    >
                      <i class="fas fa-check-circle"></i> Procesar
                      <strong>Salida</strong>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- FIN MODAL DESHUCION -->
      </form>
      <!-- FIN MODAL SALIDAD -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activo: false,
      // Cuando inicia oculta los demas input en el modal Desahucio
      mostrar_detalles: false,
      salida: false,
      is_valido: false,
      is_admin: false,
      btn_procesado: false,
      // CONTROLES DEL FORMULARIO
      input_buscar: false,
      btn_procesar_salidad: false,
      btn_procesar_entrada: false,
      btn_cerrar: true,
      btn_enviar: false,
      btn_buscar: false,
      //   dynamicValue: false,
      db_solicitudes: {},
      db_empleados: {},
      db_infosolicitud: {},
      data_departamentos: [],
      data_puestos: [],
      data_localidad: [],
      nombre_completo: null,
      empleado_nombre: null,
      empleado_email: null,
      buscar_empleado: null,
      empleado_id: null,
      empleado_usuario: null,
      empleado_supervisor: null,
      empleado_departamento: null,
      empleado_localidad: null,
      empleado_puesto: null,
      solicitante: null,
      identidad_info: null,
      supervisor_info: null,
      tipoSolicitud: null,
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

    // ----------------------------------------------------------------------------
    // PETICIONES TIPO - POST
    // ----------------------------------------------------------------------------
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
            title: "Solicitud realizada exitosamente"
          });
        })
        //DE LO CONTRARIO
        .catch(() => {
          this.$Progress.fail();
        });
    },
    // ----------------------------------------------------------------------------
    // PETICIONES TIPO - DELETE
    // ----------------------------------------------------------------------------
    deleteSalida(empleado_usuario) {
      if (this.is_valido) {
        $("#modal-detalles").modal("hide");
        swal
          .fire({
            title: "<strong >ATENCION !</strong> ",
            html:
              "Esta haciendo una solicitud de<strong> salida del empleado </strong> <br> " +
              "<h2>" +
              this.empleado_nombre +
              "</h2>",
            footer:
              '<button type="button" class="btn-block btn btn-outline-primary disabled">Esta accion genera un ticket en <strong>serviceskit</strong> </button>',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, realizar la solicitud",
            showLoaderOnConfirm: true,
            timerProgressBar: true
          })
          .then(result => {
            if (result.value) {
              this.$Progress.start();
              //Envio el request al servidor - backend
              return axios
                .delete("/deleteSalida/" + empleado_usuario)
                .then(response => {
                  Fire.$emit("RecargarData");
                  toast.fire({
                    type: "success",
                    title: "Solicitud realizada exitosamente"
                  });
                  this.$Progress.finish();
                  this.modalCierre();
                })
                .catch(error => {
                  // swal.showValidationMessage(`Request failed: ${error}`);
                  swal.fire({
                    icon: "error",
                    title: "Solicitud existente",
                    text: "Existe una solicitud vinculada a este empleado",
                    footer: "Validacion del usuario"
                  });
                });
            }
            this.modalCierre();
          });
      }
    },
    // VENTANA MODAL - MODAL DE INFORMACION
    Informacion: function(solicitud) {
      // RESERVADO PARA EL ADMINISTRADOR - CONTROL DESDE EL FRONDEND
      this.is_admin = true;

      //-----------------------------------------------------------
      this.btn_enviar = false;
      this.btn_buscar = false;
      this.mostrar_detalles = true;
      // Esto le activa el color indicando cuando es de salida o entrada
      if (solicitud.tipo === 1) {
        this.salida = false;
      } else {
        this.salida = true;
      }

      if (solicitud.estado == "Abierto") {
        this.btn_procesar_salidad = true;
        this.btn_procesar_entrada = true;
        this.btn_cerrar = true;
        this.btn_procesado = false;
      } else {
        this.btn_procesar_salidad = false;
        this.btn_procesar_entrada = false;
        this.btn_procesado = true;
        this.btn_cerrar = false;
      }

      this.modalDetalles();

      this.empleado_id = solicitud.id;
      // NOMBRE COMPLETO
      this.empleado_nombre = solicitud.nombre_completo;
      // IDENTIDAD
      this.empleado_usuario = solicitud.identidad;
      // DEPARTAMENTO
      this.empleado_departamento = solicitud.departamento;
      // PUESTO
      this.empleado_puesto = solicitud.puesto;
      // LOCALIDAD
      this.empleado_localidad = solicitud.localidad;
      // EMAIL
      this.empleado_email = solicitud.correo_electronico;
      // SUPERVISOR
      this.empleado_supervisor = solicitud.supervisor;
      // SOLICITANTE
      this.solicitante = solicitud.solicitante_nombre;

      this.tipoSolicitud = solicitud.tipo;

      // axios.get("/infoSolicitud/" + solicitud.id).then(response => {
      //   this.nombre_completo =
      //     response.data.nombres + " " + response.data.apellidos;

      //   this.identidad_info = response.data.identidad;
      //   this.supervisor_info = response.data.supervisor_email;
      // });
    },

    modalDetalles: function() {
      $("#modal-detalles").modal("show");
      // NOMBRE COMPLETO
      this.empleado_nombre = null;
      // IDENTIDAD
      this.empleado_usuario = null;
      // DEPARTAMENTO
      this.empleado_departamento = null;
      // PUESTO
      this.empleado_puesto = null;
      // LOCALIDAD
      this.empleado_localidad = null;
      // EMAIL
      this.empleado_email = null;
      // SUPERVISOR
      this.empleado_supervisor = null;
    },
    modalCierre() {
      this.salida = false;
      this.buscar_empleado = null;
    },

    // ----------------------------------------------------------------------------
    // PETICIONES AL ACTIVE DIRECTORY
    // ----------------------------------------------------------------------------
    procesarSalida(empleado_id) {
      let buscar = empleado_id;
      this.$Progress.start();
      axios.delete("/procesarSalida/" + buscar).then(Response => {
        Fire.$emit("RecargarData");
        toast.fire({
          type: "success",
          title: "Solicitud realizada exitosamente"
        });
        this.$Progress.finish();
        $("#modal-detalles").modal("hide");
      });
    },

    getEmpleado() {
      this.input_buscar = true;
      this.btn_buscar = true;
      this.btn_cerrar = true;
      this.mostrar_detalles = false;
      this.btn_procesar_salidad = false;
      this.btn_procesar_entrada = false;
      this.btn_procesado = false;
      this.modalDetalles();

      if (this.buscar_empleado != null) {
        let buscar = this.buscar_empleado;
        axios
          .get("/getEmpleado?q=" + buscar)
          .then(response => {
            this.$Progress.start();
            // console.log((this.db_empleados = response.data.description));
            this.btn_buscar = false;
            this.btn_enviar = true;
            this.mostrar_detalles = true;
            this.is_valido = true;
            this.db_empleados = response.data;
            // NOMBRES COMPLEETO
            this.empleado_nombre = response.data.name;
            this.empleado_usuario = response.data.samaccountname;
            // DEPARTAMENTO
            this.empleado_departamento = response.data.department;
            // PUESTO
            this.empleado_puesto = response.data.description;
            // LOCALIDAD
            this.empleado_localidad = response.data.physicaldeliveryofficename;
            // EMAIL
            this.empleado_email = response.data.userprincipalname;
            // SUPERVISOR
            this.empleado_supervisor = response.data.manager;
            this.$Progress.finish();
          })
          .catch(error => {
            // swal.showValidationMessage(`Request failed: ${error}`);
            swal.fire({
              icon: "error",
              title: "USUARIO NO EXISTENTE!",
              text: "Verifique el dato introducido",
              footer: "<a href>Validacion del usuario?</a>"
            });
          });
      }
    },

    // ----------------------------------------------------------------------------
    // PETICIONES TIPO - GET
    // ----------------------------------------------------------------------------

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