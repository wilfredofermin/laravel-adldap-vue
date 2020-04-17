
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
                  <th width="20%">Nombre</th>
                  <th width="15%">Puesto</th>
                  <th width="15%">Departamento</th>
                  <th width="5%">Estado</th>
                  <th width="5%">Prioridad</th>
                  <th width="15%">Fecha Creacion</th>
                  <th width="5%" text-align:center>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="ingreso in data_ingresos" :key="ingreso.id">
                  <td>{{ ingreso.serviceskit }}</td>
                  <td>{{ ingreso.cedula}}</td>
                  <td>{{ ingreso.primer_nombre}} {{ingreso.sn}} {{ingreso.primer_apellido}} {{ingreso.segundo_apellido}}</td>
                  <td>{{ ingreso.puesto }}</td>
                  <td>{{ ingreso.departamento }}</td>
                  <td>{{ ingreso.estado }}</td>
                  <td>{{ ingreso.Prioridad }}</td>
                  <td>{{ ingreso.created_at | fechas }}</td>
                  <td pl-4>
                    <a ref="#">
                      <i class="fas fa-ellipsis-v"></i>
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
      <form
        @submit.prevent="editmode ? ActualizarUsuario() : NuevoIngreso()"
        @keydown="form.onKeydown($event) "
      >
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
                <h5 class="modal-title" v-show="!editmode" id="addnew">NUEVA SOLICITUD</h5>
                <h5 class="modal-title" v-show="editmode" id="addnew">ACTUALIZAR INFO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="alert alert-secondary" role="alert" v-show="editmode">
                  <div class="form-group centered">
                    <div class="col-md-12">
                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                          <input type="radio" name="options" id="Normal" checked /> Normal
                        </label>
                        <label class="btn btn-secondary">
                          <input type="radio" name="options" id="alta" autocomplete="off" /> Alta
                        </label>
                        <label class="btn btn-secondary">
                          <input type="radio" name="options" id="baja" autocomplete="off" /> Baja
                        </label>
                      </div>
                    </div>
                  </div>
                  <!-- <small>Activo ?</small> -->
                  <br />
                </div>
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
                            placeholder="Cedula"
                            ref="cedula"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            pattern="\d*"
                            maxlength="11"
                            id="cedula"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('cedula') }"
                          />
                          <has-error :form="form" field="nombre"></has-error>
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
                            ref="SN"
                            pattern="\d*"
                            maxlength="1"
                            id="segundo_nombre"
                            autofocus
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
                        v-model="form.select_departamento"
                        id="departamento"
                        class="form-control"
                      >
                        <option value selected disabled hidden>Departamento</option>
                        <option
                          v-for="depatamento in data_departamentos"
                          :key="depatamento.id"
                          :value="depatamento.id"
                        >{{ depatamento.nombre }}</option>
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
                        v-model="form.select_puesto"
                        id="puesto"
                        class="form-control"
                        :class="{ 'is-invalid':form.errors.has('select_puesto')}"
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
                        v-model="form.select_localidad"
                        id="localidad"
                        class="form-control"
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
                  <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                  </button>
                  <button v-show="editmode" type="submit" class="btn btn-success">
                    <i class="fas fa-sync-alt"></i> Actualizar
                  </button>
                  <button v-show="!editmode" type="submit" class="btn btn-primary">
                    <i class="far fa-paper-plane"></i>Enviar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <!-- fin modal -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editmode: false,
      data_ingresos: {},
      data_departamentos: {},
      data_puestos: {},
      data_localidad: {},
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
    MostrarModal: function() {
      this.editmode = false;
      this.form.reset();
      $("#addnew").modal("show");
    },

    getIngresos() {
      axios.get("/getIngresos").then(response => {
        this.data_ingresos = response.data;
      });
    },
    getDepartamentos() {
      axios.get("/getDepartamentos").then(response => {
        this.data_departamentos = response.data;
      });
    },
    getLocalidad() {
      axios.get("/getLocalidad").then(response => {
        this.data_localidad = response.data;
        document.getElementById("localidad").disabled = false;
      });
    },

    getPuestos() {
      this.form.select_puesto = "";

      if (this.form.select_departamento != "") {
        axios
          .get("/getPuestos", {
            params: { departamento_id: this.form.select_departamento }
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
    getSupervisor() {
      console.log(this.form.supervisor);
    }
  },
  created() {
    this.getIngresos();
    this.getDepartamentos();
    // this.getLocalidad();

    // this.getPuestos();
  },

  mounted() {
    document.getElementById("puesto").disabled = true;
    document.getElementById("localidad").disabled = true;
    // console.log("Component mounted.");
    // document.getElementById("puesto").disabled = true;
  }
};
</script>
