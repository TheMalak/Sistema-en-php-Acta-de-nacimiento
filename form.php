    <form id="newRegister">
      <div class="row mt-4">
        <h4>Datos generales</h4>
        <hr>
        <div class="col">
          <label class="mb-2">Curp <span class="required">*</span></label>
          <input id="curp" type="text" class="form-control" placeholder="curp" required>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <label class="mb-2">Nombre's <span class="required">*</span></label>
          <input id="name" type="text" class="form-control" placeholder="Last name">
        </div>
        <div class="col">
          <label class="mb-2">Apellido Paterno <span class="required">*</span></label>
          <input id="lastName1" type="text" class="form-control" placeholder="Apellido Paterno" required>
        </div>
        <div class="col">
          <label class="mb-2">Apellido Materno <span class="required">*</span></label>
          <input id="lastName2" type="text" class="form-control" placeholder="Apellido materno" required>
        </div>
        <div class="col">
          <label class="mb-2">Sexo <span class="required">*</span></label>
          <select class="form-control" id="registersexo" required>
            <option value="1">Masculino</option>
            <option value="0">Femenino</option>
          </select>
        </div>
      </div>

      <div class="row mt-4">
        <h4>Entdad de Registro</h4>
        <hr>
        <div class="col-6">
          <label class="mb-2">Estado <span class="required">*</span></label>
          <select class="form-control" id="registerState" required>
            <!-- php function option -->
            <option value="0">-</option>
            <?php getStatesForSelect(); ?>
          </select>
        </div>
        <div id="municipiosSelect" class="col-6">
          <label class="mb-2">Municipio <span class="required">*</span></label>
          <input id="textMunicipio" type="text" class="form-control d-none">
          <select class="form-control" id="registerMunicipio" disabled required>
            <!-- php function option -->
            <option value="0">-</option>
          </select>
        </div>
      </div>

      <div class="row mt-4">
        <h4>Fecha de nacimiento</h4>
        <hr>
        <div class="col">
          <label class="mb-2">Día <span class="required">*</span></label>
          <input id="birthDayDay" type="number" class="form-control" placeholder="Día" required>
        </div>
        <div class="col">
          <label class="mb-2">Mes <span class="required">*</span></label>
          <input id="birthDayMonth" type="number" class="form-control" placeholder="Mes" required>
        </div>
        <div class="col">
          <label class="mb-2">Año <span class="required">*</span></label>
          <input id="birthDayYear" type="number" class="form-control" placeholder="Año" required>
        </div>
      </div>

      <div class="row mt-4">
        <h4>Filiales</h4>
        <hr>
        <h5 class="mt-4">Filial 1</h5>
        <hr>
        <div class="col">
          <label class="mb-2">Nombre's <span class="required">*</span></label>
          <input id="filial1Name" type="text" class="form-control" placeholder="Nombre's" required>
        </div>
        <div class="col">
          <label class="mb-2">Apellido Paterno <span class="required">*</span></label>
          <input id="filial1LastName1" type="text" class="form-control" placeholder="Apellido Paterno" required>
        </div>

        <div class="col">
          <label class="mb-2">Apellido Materno <span class="required">*</span></label>
          <input id="filial1LastName2" type="text" class="form-control" placeholder="Apellido materno" required>
        </div>
        <div class="col">
          <label class="mb-2">Sexo <span class="required">*</span></label>
          <select class="form-control" id="filial1Sexo" required>
            <option value="1">Masculino</option>
            <option value="0">Femenino</option>
          </select>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col">
          <label class="mb-2">CURP</label>
          <input id="filial1Curp" type="text" class="form-control" placeholder="Curp">
        </div>
        <div class="col">
          <label class="mb-2">Nacionalidad <span class="required">*</span></label>
          <select class="form-control" id="filial1Country" required>
            <?php getNacionalidadSelect(); ?>
          </select>
        </div>
      </div>

      <div class="row mt-5">
        <h5>Filial 2</h5>
        <hr>
        <div class="col">
          <label class="mb-2">Nombre's</label>
          <input id="filial2Name" type="text" class="form-control" placeholder="Last name">
        </div>
        <div class="col">
          <label class="mb-2">Apellido Paterno</label>
          <input id="filial2LastName1" type="text" class="form-control" placeholder="Apellido Paterno">
        </div>
        <div class="col">
          <label class="mb-2">Apellido Materno</label>
          <input id="filial2LastName2" type="text" class="form-control" placeholder="Apellido materno">
        </div>
        <div class="col">
          <label class="mb-2">Sexo</label>
          <select class="form-control" id="filial2Sexo" required>
            <option value="1">Masculino</option>
            <option value="0">Femenino</option>
          </select>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col">
          <label class="mb-2">CURP</label>
          <input id="filial2Curp" type="text" class="form-control" placeholder="Curp">
        </div>
        <div class="col">
          <label class="mb-2">Nacionalidad</label>
          <select class="form-control" id="filial2Country">
            <?php getNacionalidadSelect(); ?>
          </select>
        </div>
      </div>

      <div class="row mt-5">
        <h4>Datos de Registro</h4>
        <hr>
        <div class="col">
          <label class="mb-2">Número de certificado</label>
          <input id="certificateNumber" type="number" class="form-control" placeholder="Número de Certificado">
        </div>

        <div class="col">
          <label class="mb-2">Año de Registro <span class="required">*</span></label>
          <input id="registerDate" type="number" class="form-control" placeholder="Año de Registro" required>
        </div>

        <div class="col">
          <label class="mb-2">Libro <span class="required">*</span></label>
          <input id="book" type="number" class="form-control" placeholder="Libro" required>
        </div>

        <div class="col">
          <label class="mb-2">Número de Acta <span class="required">*</span></label>
          <input id="actaNumber" type="number" class="form-control" placeholder="Número de Acta" required>
        </div>

        <div class="col">
          <label class="mb-2">Oficialía <span class="required">*</span></label>
          <input id="oficialia" type="number" class="form-control" placeholder="Oficialía" required>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col">
          <label class="mb-2">Identificador Electrónico <span class="required">*</span></label>
          <input id="identifierElectronic" type="number" class="form-control" placeholder="Identificador Electrónico"
            required>
        </div>
      </div>

      <div class="row mt-5">
        <h4>Fecha de Registro</h4>
        <hr>
        <div class="col">
          <label class="mb-2">Día <span class="required">*</span></label>
          <input id="registerDay" type="number" class="form-control" placeholder="Día" required>
        </div>
        <div class="col">
          <label class="mb-2">Mes <span class="required">*</span></label>
          <input id="registerMonth" type="number" class="form-control" placeholder="Mes" required>
        </div>
        <div class="col">
          <label class="mb-2">Año <span class="required">*</span></label>
          <input id="registerYear" type="number" class="form-control" placeholder="Año" required>
        </div>
      </div>

      <br><br>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary m-auto d-flex">Enviar</button>
      </div>
      <br><br>

      </div>

    </form>