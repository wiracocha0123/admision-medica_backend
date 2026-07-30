# Diagramas del Sistema de Admisión Médica

## 1. Diagrama de Clases

```plantuml
@startuml clases_admision
!define ENTITY_COLOR #FFE6E6

skinparam classBackgroundColor<<entity>> ENTITY_COLOR
skinparam classBorderColor #CC0000

class User {
    - id: int
    - name: string
    - apellido: string
    - email: string
    - password: string
    - telefono: string
    - email_verified_at: datetime
    - created_at: timestamp
    - updated_at: timestamp
    --
    + operador: Operador
    + roles: Role[]
}

class Operador {
    - id: int
    - user_id: int
    - nombre: string
    - apellido: string
    - email: string
    - usuario: string
    - DNI: string
    - horario_semanal: array
    - created_at: timestamp
    - updated_at: timestamp
    --
    + user: User
    + citas: Cita[]
}

class Paciente {
    - id: int
    - nombre: string
    - apellido: string
    - tipo_documento: string
    - dni: string
    - HistoriaClinica: string
    - telefono: string
    - email: string
    - direccion: string
    - etapa_vida: string
    - gestante: boolean
    - detalle_gestante: string
    - estado: string
    - created_at: timestamp
    - updated_at: timestamp
    --
    + citas: Cita[]
}

class Cita {
    - id: int
    - paciente_id: int
    - personal_salud_id: int
    - especialidad_id: int
    - fecha: date
    - hora: time
    - operador_id: int
    - nro_ticket: int
    - total_tickets_dia: int
    - observaciones: string
    - estado: string
    - created_at: timestamp
    - updated_at: timestamp
    --
    + paciente: Paciente
    + personalSalud: PersonalSalud
    + especialidad: Especialidad
    + operador: Operador
}

class PersonalSalud {
    - id: int
    - nombres: string
    - apellidos: string
    - dni: string
    - telefono: string
    - email: string
    - especialidad_id: int
    - cargo: string
    - horario_mensual: array
    - created_at: timestamp
    - updated_at: timestamp
    --
    + especialidad: Especialidad
    + citas: Cita[]
    + pacientes: Paciente[]
}

class Especialidad {
    - id: int
    - UPS: string
    - especialidad: string
    - created_at: timestamp
    - updated_at: timestamp
    --
    + citas: Cita[]
    + personalSalud: PersonalSalud[]
    + cuposPorEspecialidad: CuposPorEspecialidad[]
}

class CuposPorEspecialidad {
    - id: int
    - fecha: date
    - especialidad_id: int
    - cantidad_cupos: int
    - created_at: timestamp
    - updated_at: timestamp
    --
    + especialidad: Especialidad
}

class Role {
    - id: int
    - name: string
    - guard_name: string
    --
    - operador
    - supervisor
}

' Relaciones
User "1" -- "1" Operador : tiene
Operador "1" -- "*" Cita : crea
Paciente "1" -- "*" Cita : registra
PersonalSalud "1" -- "*" Cita : atiende
Especialidad "1" -- "*" Cita : pertenece
Especialidad "1" -- "*" PersonalSalud : trabaja en
Especialidad "1" -- "*" CuposPorEspecialidad : define
User "*" -- "*" Role : posee

@enduml
```

---

## 2. Diagrama de Casos de Uso

```plantuml
@startuml casos_uso
!define ACTOR_COLOR #E1F5FE
!define SYSTEM_COLOR #FFF3E0

skinparam actorBackgroundColor ACTOR_COLOR
skinparam usecaseBackgroundColor SYSTEM_COLOR
skinparam packageBackgroundColor #F3E5F5

left to right direction

actor "Operador" as op
actor "Supervisor" as sup
actor "Personal Salud" as ps
actor "Paciente" as pac

rectangle "Sistema de Admisión Médica" {
    
    usecase "Autenticarse" as UC1
    usecase "Gestionar Especialidades" as UC2
    usecase "Registrar Paciente" as UC3
    usecase "Solicitar Cita" as UC4
    usecase "Ver Disponibilidad de Cupos" as UC5
    usecase "Generar Número de Ticket" as UC6
    usecase "Confirmar Cita" as UC7
    usecase "Ver Citas Programadas" as UC8
    usecase "Filtrar Citas" as UC9
    usecase "Actualizar Estado de Cita" as UC10
    usecase "Configurar Cupos por Especialidad" as UC11
    usecase "Ver Reportes" as UC12
    usecase "Gestionar Personal de Salud" as UC13
    usecase "Ver Perfil de Usuario" as UC14
    usecase "Cambiar Contraseña" as UC15
}

' Relaciones Operador
op --> UC1
op --> UC3
op --> UC4
op --> UC5
op --> UC6
op --> UC7
op --> UC8
op --> UC9
op --> UC10
op --> UC14
op --> UC15

' Relaciones Supervisor
sup --> UC1
sup --> UC2
sup --> UC8
sup --> UC9
sup --> UC11
sup --> UC12
sup --> UC13
sup --> UC14
sup --> UC15

' Relaciones Paciente
pac -.-> UC3
pac -.-> UC4
pac -.-> UC5

' Personal Salud
ps --> UC8
ps --> UC10

' Include/Extend
UC4 ..|> UC5 : <<include>>
UC4 ..|> UC6 : <<include>>
UC4 ..|> UC7 : <<include>>
UC8 ..|> UC9 : <<include>>

@enduml
```

---

## 3. Diagrama Secuencial - Solicitud de Cita

```plantuml
@startuml secuencial_cita
participant "Operador" as op
participant "Sistema" as sys
participant "CitasController" as ctrl
participant "BD" as db
participant "Especialidad" as esp

op -> sys: POST /api/citas
activate sys
sys -> ctrl: store(StoreCitaRequest)
activate ctrl

ctrl -> db: obtener fecha y especialidad
activate db
db --> ctrl: datos de entrada validados
deactivate db

ctrl -> db: contar citas existentes (fecha + especialidad)
activate db
db --> ctrl: citasExistentes = X
deactivate db

ctrl -> db: obtener cupo configurado
activate db
db --> ctrl: cupoConfig
deactivate db

alt Cupos Disponibles
    ctrl -> db: obtener siguiente ticket
    activate db
    db --> ctrl: nro_ticket
    deactivate db
    
    ctrl -> db: crear nueva Cita
    activate db
    db --> ctrl: Cita creada (id)
    deactivate db
    
    ctrl -> sys: success(cita creada)
    sys --> op: 201 Created - Cita registrada
else Cupos Llenos
    ctrl -> sys: error(cupos_llenos, 400)
    sys --> op: 400 Bad Request - Cupos completos
end

deactivate ctrl
deactivate sys

@enduml
```

---

## 4. Diagrama de Actividades - Proceso de Admisión

```plantuml
@startuml actividades_admision
start
:Operador inicia sesión;
:Verifica datos de acceso;
if (Login exitoso?) then (sí)
    :Accede al sistema;
else (no)
    :Muestra error de autenticación;
    stop
endif

:Selecciona "Nueva Cita";
:Sistema solicita datos de paciente;
if (Paciente existe?) then (sí)
    :Carga datos del paciente;
else (no)
    :Registra nuevo paciente;
endif

:Selecciona especialidad;
:Ingresa fecha deseada;
:Sistema consulta disponibilidad;
if (Cupos disponibles?) then (sí)
    :Genera número de ticket;
    :Asigna turno;
else (no)
    :Sugiere otras fechas;
    :Retorna a selección de fecha;
endif

:Asigna Personal de Salud;
:Añade observaciones (opcional);
:Confirma datos de cita;
:Sistema valida toda la información;

if (Datos válidos?) then (sí)
    :Guarda Cita en BD;
    :Genera comprobante;
    :Muestra confirmación;
else (no)
    :Muestra errores;
    :Retorna a edición;
endif

:Operador imprime o envía comprobante;
:Paciente recibe información de cita;
:Fin del proceso;
stop

@enduml
```

---

## 5. Diagrama de Componentes

```plantuml
@startuml componentes_admision
!define COMPONENT_COLOR #E3F2FD
!define DB_COLOR #FCE4EC
!define API_COLOR #F3E5F5

skinparam componentBackgroundColor COMPONENT_COLOR
skinparam databaseBackgroundColor DB_COLOR

package "Frontend (Cliente Web)" {
    component [Interfaz de Usuario] as UI
}

package "Backend - Laravel" {
    package "API REST" {
        component [AuthController] as AuthCtrl
        component [CitasController] as CitasCtrl
        component [PacientesController] as PacCtrl
        component [EspecialidadesController] as EspCtrl
        component [PersonalSaludController] as PSaludCtrl
        component [OperadoresController] as OpCtrl
        component [DashboardController] as DashCtrl
        component [ReporteController] as ReportCtrl
    }
    
    package "Business Logic" {
        component [CitasService] as CitasServ
        component [PacientesService] as PacServ
        component [CuposService] as CuposServ
        component [AuthService] as AuthServ
    }
    
    package "Models/ORM" {
        component [User] as UserModel
        component [Operador] as OperadorModel
        component [Paciente] as PacienteModel
        component [Cita] as CitaModel
        component [PersonalSalud] as PSaludModel
        component [Especialidad] as EspecialidadModel
        component [CuposPorEspecialidad] as CuposModel
    }
    
    package "Middleware & Auth" {
        component [JWTAuth] as JWT
        component [RoleMiddleware] as RoleMid
        component [ApiResponse Trait] as ApiResp
    }
}

database "PostgreSQL/MySQL" as DB {
    component [Tabla Users] as TblUsers
    component [Tabla Operadores] as TblOp
    component [Tabla Pacientes] as TblPac
    component [Tabla Citas] as TblCita
    component [Tabla PersonalSalud] as TblPSalud
    component [Tabla Especialidades] as TblEsp
    component [Tabla Cupos] as TblCupos
}

' Relaciones Frontend -> Backend
UI --> AuthCtrl : login/logout
UI --> CitasCtrl : CRUD citas
UI --> PacCtrl : CRUD pacientes
UI --> EspCtrl : CRUD especialidades
UI --> PSaludCtrl : CRUD personal
UI --> OpCtrl : CRUD operadores
UI --> DashCtrl : consultar stats
UI --> ReportCtrl : generar reportes

' Relaciones Controllers -> Services
AuthCtrl --> AuthServ : autenticar
CitasCtrl --> CitasServ : gestionar citas
CitasCtrl --> CuposServ : validar cupos
PacCtrl --> PacServ : gestionar pacientes

' Relaciones Services -> Models
CitasServ --> CitaModel : crear/actualizar
CuposServ --> CuposModel : validar cupos
CitasServ --> PacienteModel : cargar paciente
AuthServ --> UserModel : validar usuario

' Relaciones Controllers -> Models (directo para reads)
CitasCtrl --> CitaModel : consultar
EspCtrl --> EspecialidadModel : consultar

' Relaciones Middleware
AuthCtrl -.-> JWT : validar token
CitasCtrl -.-> RoleMid : verificar rol
AuthCtrl -.-> ApiResp : formato respuesta

' Relaciones Models -> DB
UserModel --> TblUsers
OperadorModel --> TblOp
PacienteModel --> TblPac
CitaModel --> TblCita
PSaludModel --> TblPSalud
EspecialidadModel --> TblEsp
CuposModel --> TblCupos

@enduml
```

---

## 6. Diagrama de Estados - Ciclo de Vida de una Cita

```plantuml
@startuml estados_cita
[*] --> PENDIENTE

PENDIENTE: Estado inicial\nAl crear la cita

PENDIENTE --> CONFIRMADA : Operador confirma\nconfirm_cita()
PENDIENTE --> CANCELADA : Operador cancela\ncancel_cita()

CONFIRMADA: Cita confirmada\nAguardando atención

CONFIRMADA --> EN_ATENCION : Personal de salud\ncomienza atención\nstart_atencion()

CONFIRMADA --> CANCELADA : Cancelación por\ninasistencia del paciente\ncancel_cita()

EN_ATENCION: Personal de salud\nausente o en pausa

EN_ATENCION --> FINALIZADA : Se completa\nla atención\nfinish_atencion()

EN_ATENCION --> CANCELADA : Se cancela\ndurante atención\ncancel_cita()

FINALIZADA: Cita completada\nRegistro finalizado

FINALIZADA --> [*]

CANCELADA: Cita cancelada\nNo se realizó

CANCELADA --> [*]

note right of PENDIENTE
  - Cita registrada en el sistema
  - Número de ticket asignado
  - Paciente notificado
end note

note right of CONFIRMADA
  - Cita confirmada por operador
  - Paciente presente o confirmado
  - En espera de atención
end note

note right of EN_ATENCION
  - Personal de salud atendiendo
  - Se registran observaciones
  - Historial clínico actualizado
end note

note right of FINALIZADA
  - Cita completada exitosamente
  - Registro finalizado
  - Datos persistidos en BD
end note

note right of CANCELADA
  - Cita anulada o no realizada
  - Se libera el cupo
  - Se registra el motivo
end note

@enduml
```

---

## Descripción General del Sistema

### Entidades Principales:
- **User**: Usuario del sistema con autenticación JWT
- **Operador**: Personal administrativo que registra citas
- **Paciente**: Personas que solicitan citas médicas
- **Cita**: Registro de atención médica programada
- **PersonalSalud**: Médicos/profesionales de salud
- **Especialidad**: Tipos de servicios médicos
- **CuposPorEspecialidad**: Control de capacidad por especialidad y fecha
- **Role**: Roles del sistema (operador, supervisor)

### Flujos Principales:
1. **Autenticación**: JWT con roles (operador, supervisor)
2. **Gestión de Citas**: CRUD con validación de cupos
3. **Control de Tickets**: Numeración automática por especialidad y fecha
4. **Reportes**: Consulta de citas por personal médico
5. **Perfil de Usuario**: Gestión de datos y contraseña

