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
                  <!-- <td>{{ solicitud.estado }}</td> -->
                  <td>{{ solicitud.Prioridad }}</td>
                  <td>{{ solicitud.created_at | fechas }}</td>
                  <td>{{ solicitud.created_at | fechas }}</td>
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
      <!-- INICIO BOTTON floating -->
      <!-- Floating Action Button like Google Material -->

      <!-- FIN BOOTON floating -->
      <!-- Modal -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activo: false,
      db_solicitudes: {}
    };
  },
  methods: {
    getSolicitudes() {
      axios.get("/getSolicitudes").then(response => {
        this.db_solicitudes = response.data;
      });
    }
  },
  created() {
    this.getSolicitudes();
  }
};
</script>