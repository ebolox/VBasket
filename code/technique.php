  <div id="technique_button_bar" class="row vb-navbar btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">

    <input type="hidden" name="menu[selector]" value="player" />
    <div class="col"></div>
    <div class="col-6 text-left">
      <div class="btn-group btn-radio mr-5" id="menu_selector" role="group" aria-label="Menù selettore">
        <button type="button" class="btn btn-success btn-sm" data-value="player_parameters">
          <i class="bi bi-person-standing"></i><span>Giocatore</span>
        </button>
        <button type="button" class="btn btn-success btn-sm" data-value="action_parameters">
          <i class="bi bi-lightning-fill"></i><span>Azione</span>
        </button>
        <button type="button" class="btn btn-success btn-sm" data-value="field_parameters">
          <i class="bi bi-clipboard2-heart"></i><span>Campo</span>
        </button>
      </div>
      <div class="vb-menu" id="player_parameters">
  
        <input type="hidden" name="player[phase]" value="offense" />
        <div id="player_phase" class="btn-group btn-radio" role="group" aria-label="Fase di gioco">      
          <button type="button" class="btn btn-success btn-sm" data-value="offense">
            <i class="bi bi-dribbble"></i><span>Attacco</span>
          </button>
          <button type="button" class="btn btn-success btn-sm" data-value="defense">
            <i class="bi bi-shield-shaded"></i><span>Difesa</span>
          </button>
        </div>
  
        <div id="btn_player_orientation" class="btn-group" role="group" aria-label="Direzione piedi del giocatore">
          <input type="hidden" name="player[orientation]" value="basket" />
          <button class="btn btn-secondary btn-sm" disabled>Orientamento</button>
        
          <div class="btn-group" role="group">
            <button id="player_orientation" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Canestro
            </button>
            <div class="dropdown-menu" aria-labelledby="player[orientation]">
              <a class="dropdown-item" href="#" data-value="basket">Canestro</a>
              <a class="dropdown-item" href="#" data-value="ball">Palla</a>
            </div>
          </div>
        </div>
  
        <div class="btn-group" id="btn_player_number">
          <input type="hidden" name="player[number]" value="false" />
          <button class="btn btn-secondary btn-sm" disabled>Numeri</button>
          <div class="btn-group-append">
            <button class="btn btn-danger btn-sm" id="player_number"><i class="bi bi-x-lg"></i></button>
          </div>
        </div>
  
        <div class="btn-group" id="btn_player_role">
          <input type="hidden" name="player[role]" value="false" />
          <button class="btn btn-secondary btn-sm" disabled>Ruoli</button>
          <div class="btn-group-append">
            <button class="btn btn-danger btn-sm" id="player_role"><i class="bi bi-x-lg"></i></button>
          </div>
        </div>
  
      </div>
      <div class="vb-menu" id="action_parameters">
  
        <input type="hidden" name="action[phase]" value="offense" />
        <div class="btn-group btn-radio" id="action_phase" role="group" aria-label="Fase di gioco">
          <button type="button" class="btn btn-success btn-sm" data-value="offense">
            <i class="bi bi-dribbble"></i><span>Attacco</span>
          </button>
          <button type="button" class="btn btn-success btn-sm" data-value="defense">
            <i class="bi bi-shield-shaded"></i><span>Difesa</span>
          </button>
        </div>
  
        <div id="btn_action_type" class="btn-group" role="group" aria-label="Azione da rappresentare">
          <input type="hidden" name="action[type]" value="pass" />
          <button class="btn btn-secondary btn-sm" disabled>Azione</button>
        
          <div class="btn-group" role="group">
            <button id="action_type" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Passaggio
            </button>
            <div class="dropdown-menu" aria-labelledby="action[type]">
              <a class="dropdown-item" href="#" data-value="pass">Passaggio</a>
              <a class="dropdown-item" href="#" data-value="dribble">Palleggio</a>
              <a class="dropdown-item" href="#" data-value="shot">Tiro</a>
              <a class="dropdown-item" href="#" data-value="shift">Spostamento</a>
              <a class="dropdown-item" href="#" data-value="free">Smarcamento</a>
              <a class="dropdown-item" href="#" data-value="block">Blocco</a>
            </div>
          </div>
        </div>
  
      </div>
      <div class="vb-menu" id="field_parameters">
  
        <div id="btn_field_type" class="btn-group" role="group" aria-label="Tipo di campo">
          <input type="hidden" name="field[type]" value="white" />
          <button class="btn btn-secondary btn-sm" disabled>Campo</button>
        
          <div class="btn-group" role="group">
            <button id="field_type" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Neutro
            </button>
            <div class="dropdown-menu" aria-labelledby="field[type]">
              <a class="dropdown-item" href="#" data-value="white">Neutro</a>
              <a class="dropdown-item" href="#" data-value="parquet">Parquet</a>
              <a class="dropdown-item" href="#" data-value="blue">Linoleum</a>
            </div>
          </div>
        </div>
  
        <div id="btn_field_size" class="btn-group" role="group" aria-label="Dimensioni del campo">
          <input type="hidden" name="field[size]" value="half" />
          <button class="btn btn-secondary btn-sm" disabled>Dimensioni</button>
        
          <div class="btn-group" role="group">
            <button id="field_size" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Metà
            </button>
            <div class="dropdown-menu" aria-labelledby="field[size]">
              <a class="dropdown-item" href="#" data-value="half">Metà</a>
              <a class="dropdown-item" href="#" data-value="whole">Intero</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col"></div>

  </div>
  <div id="technique_board" class="vb-content vb-form bg-basket mt-4">

    <svg id="action_board" width="900" height="675" xmlns="http://www.w3.org/2000/svg"></svg>

  </div>
  <div id="player_button_bar" class="vb-free bg-basket btn-rounded">

    <input type="hidden" id="player_handled" value />
    <button id="player_action" type="button" class="btn btn-success btn-sm btn-circle"><i class="bi bi-lightning-fill"></i></button>
    <button id="player_rotate_left" type="button" class="btn btn-secondary btn-sm btn-circle"><i class="bi bi-arrow-counterclockwise"></i></button>
    <button id="player_rotate_right" type="button" class="btn btn-secondary btn-sm btn-circle"><i class="bi bi-arrow-clockwise"></i></button>
    <button id="player_delete" type="button" class="btn btn-danger btn-sm btn-circle"><i class="bi bi-trash-fill"></i></button>

  </div>
  <div id="action_button_bar" class="vb-free bg-basket btn-rounded">

    <input type="hidden" id="action_handled" value />
    <button id="action_player" type="button" class="btn btn-success btn-sm btn-circle"><i class="bi bi-person-standing"></i></button>
    <button id="action_continue" type="button" class="btn btn-secondary btn-sm btn-circle"><i class="bi bi-share"></i></button>
    <button id="action_delete" type="button" class="btn btn-danger btn-sm btn-circle"><i class="bi bi-trash-fill"></i></button>

  </div>
  <script src="assets/javascript/technique.js"></script>
