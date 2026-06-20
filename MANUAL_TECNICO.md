# 📚 MANUAL TÉCNICO - SISTEMA DE ADMISIÓN MÉDICA

**Versión:** 2.0  
**Fecha:** Junio 2026  
**Estado:** ✅ COMPLETO (Frontend + Backend)  
**Descripción:** Manual técnico de arquitectura y desarrollo del Sistema de Admisión Médica

---

## 📑 TABLA DE CONTENIDOS

1. [Introducción Técnica](#introducción-técnica)
2. [Stack Tecnológico](#stack-tecnológico)
3. [Arquitectura General](#arquitectura-general)
4. [Estructura de Carpetas](#estructura-de-carpetas)
5. [Frontend - React](#frontend---react)
6. [Componentes del Sistema](#componentes-del-sistema)
7. [Servicios y APIs](#servicios-y-apis)
8. [Autenticación y Seguridad](#autenticación-y-seguridad)
9. [Gestión de Estado](#gestión-de-estado)
10. [Rutas y Navegación](#rutas-y-navegación)
11. [Configuración de Desarrollo Frontend](#configuración-de-desarrollo)
12. [Deployment Frontend](#deployment)
13. [Testing Frontend](#testing)
14. [Troubleshooting Frontend](#troubleshooting)
15. [Backend - Laravel](#backend---laravel)
16. [Modelos de Datos Backend](#modelos-de-datos)
17. [Controladores Backend](#controladores-principales)
18. [API Endpoints](#rutas-api)
19. [Autenticación JWT](#autenticación-jwt)
20. [Validaciones Backend](#validaciones-form-requests)
21. [Base de Datos](#base-de-datos)
22. [Instalación Backend](#instalación-y-configuración)
23. [Deployment Backend](#deployment-backend)
24. [Testing Backend](#testing-backend)
25. [Troubleshooting Backend](#troubleshooting-backend)
26. [Performance](#performance)

---

## 🎯 INTRODUCCIÓN TÉCNICA

El **Sistema de Admisión Médica** es una aplicación web full-stack diseñada para gestionar citas médicas, pacientes, especialidades y reportes.

**Características principales:**
- ✅ Arquitectura modular y escalable
- ✅ Interfaz responsiva
- ✅ Autenticación por JWT
- ✅ Control de acceso basado en roles (RBAC)
- ✅ API RESTful
- ✅ Base de datos relacional

**Estructura:**
```
Frontend (React/Vite) ↔ Backend (Laravel/Node/Python) ↔ Database (MySQL/PostgreSQL)
```

---

## 💻 STACK TECNOLÓGICO

### Frontend
| Tecnología | Versión | Propósito |
|-----------|---------|----------|
| **React** | 18+ | Framework UI |
| **Vite** | 4+ | Build tool y dev server |
| **React Router** | 6+ | Enrutamiento |
| **Axios** | 1+ | Cliente HTTP |
| **Context API** | Built-in | Gestión de estado global |
| **CSS3/Tailwind** | - | Estilos responsivos |
| **JavaScript (ES6+)** | - | Lenguaje base |

### Backend (A Completar)
```
[Información del Backend será completada por el equipo backend]
```

### DevTools
| Herramienta | Versión | Propósito |
|-----------|---------|----------|
| **ESLint** | Latest | Linter de código |
| **Node.js** | 16+ | Runtime |
| **npm** | 7+ | Package manager |
| **Git** | Latest | Control de versiones |
| **Docker** | Latest | Contenedorización |

---

## 🏗️ ARQUITECTURA GENERAL

### Diagrama de Capas

```
┌─────────────────────────────────────┐
│      PRESENTACIÓN (React UI)         │
│  - Componentes                       │
│  - Vistas                            │
│  - Estilos                           │
└──────────────────┬──────────────────┘
                   │
┌──────────────────▼──────────────────┐
│      LÓGICA DE APLICACIÓN            │
│  - Context API (AuthContext)         │
│  - Hooks personalizados              │
│  - Rutas protegidas                  │
└──────────────────┬──────────────────┘
                   │
┌──────────────────▼──────────────────┐
│      SERVICIOS Y APIS                │
│  - authService.js                    │
│  - citasService.js                   │
│  - pacientesService.js               │
│  - API Client (axios)                │
└──────────────────┬──────────────────┘
                   │
┌──────────────────▼──────────────────┐
│   BACKEND API (Laravel/Node/Python)  │
│  - Controladores                     │
│  - Modelos                           │
│  - Rutas                             │
│  - Validaciones                      │
└──────────────────┬──────────────────┘
                   │
┌──────────────────▼──────────────────┐
│      BASE DE DATOS                   │
│  - MySQL / PostgreSQL                │
│  - Tablas de datos                   │
└─────────────────────────────────────┘
```

---

## 📁 ESTRUCTURA DE CARPETAS

```
admision-medica_frontend/
│
├── public/                          # Archivos estáticos
│   └── favicon.ico
│
├── src/                             # Código fuente principal
│   │
│   ├── main.jsx                     # Punto de entrada React
│   ├── App.jsx                      # Componente raíz
│   ├── App.css                      # Estilos globales
│   ├── index.css                    # Estilos base
│   │
│   ├── api.js                       # Configuración Axios
│   │
│   ├── components/                  # Componentes reutilizables
│   │   ├── HorarioMensualPicker.jsx
│   │   ├── HorarioSemanalDisplay.jsx
│   │   ├── HorarioSemanalPicker.jsx
│   │   ├── LoginView.jsx
│   │   ├── ProtectedRoute.jsx       # Rutas protegidas
│   │   └── Sidebar.jsx              # Menú lateral
│   │
│   ├── contexts/                    # Context API
│   │   └── AuthContext.jsx          # Autenticación global
│   │
│   ├── layouts/                     # Layouts
│   │   └── AdminLayout.jsx          # Layout principal admin
│   │
│   ├── pages/                       # Vistas por módulo
│   │   ├── Forbidden.jsx            # Error 403
│   │   └── Admin/
│   │       ├── Archivados.jsx
│   │       ├── Citas.jsx
│   │       ├── Dashboard.jsx
│   │       ├── Especialidades.jsx
│   │       ├── Operadores.jsx
│   │       ├── Pacientes.jsx
│   │       ├── Perfil.jsx
│   │       ├── Personal.jsx
│   │       ├── Reportes.jsx
│   │       └── Users.jsx
│   │
│   ├── services/                    # Servicios de API
│   │   ├── authService.js           # Auth API calls
│   │   ├── citasService.js          # Citas API calls
│   │   ├── dashboardService.js      # Dashboard API calls
│   │   ├── especialidadesService.js
│   │   ├── operadoresService.js
│   │   ├── pacientesService.js
│   │   ├── personalService.js
│   │   ├── reportesService.js
│   │   └── usersService.js
│   │
│   ├── styles/                      # Estilos adicionales
│   │   └── login.css
│   │
│   ├── views/                       # Vistas adicionales
│   │   ├── LoginView.jsx
│   │   └── Welcome.jsx
│   │
│   └── assets/                      # Imágenes, iconos, etc
│
├── vite.config.js                   # Configuración Vite
├── eslint.config.js                 # Configuración ESLint
├── package.json                     # Dependencias del proyecto
├── Dockerfile                       # Docker
├── index.html                       # HTML principal
└── README.md                        # Documentación general

```

---

## 🎨 FRONTEND - REACT

### Configuración Inicial

#### package.json (Dependencias Principales)
```json
{
  "name": "admision-medica-frontend",
  "version": "1.0.0",
  "type": "module",
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "lint": "eslint .",
    "preview": "vite preview"
  },
  "dependencies": {
    "react": "^18.2.0",
    "react-dom": "^18.2.0",
    "react-router-dom": "^6.8.0",
    "axios": "^1.3.0"
  },
  "devDependencies": {
    "@vitejs/plugin-react": "^3.1.0",
    "vite": "^4.2.0",
    "eslint": "^8.0.0"
  }
}
```

#### vite.config.js
```javascript
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
  plugins: [react()],
  server: {
    port: 3000,
    proxy: {
      '/api': {
        target: 'http://localhost:8000',
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, '')
      }
    }
  }
})
```

### Punto de Entrada

#### main.jsx
```javascript
import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'
import './index.css'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
)
```

---

## 🧩 COMPONENTES DEL SISTEMA

### 1. ProtectedRoute.jsx

**Propósito:** Proteger rutas que requieren autenticación

```javascript
// Ubicación: src/components/ProtectedRoute.jsx

import { Navigate } from 'react-router-dom'
import { useAuth } from '../contexts/AuthContext'

export default function ProtectedRoute({ children, requiredRole }) {
  const { user, isAuthenticated } = useAuth()

  // No autenticado → Login
  if (!isAuthenticated) {
    return <Navigate to="/login" />
  }

  // Sin rol requerido → Acceso permitido
  if (!requiredRole) {
    return children
  }

  // Verificar rol del usuario
  if (user?.role !== requiredRole) {
    return <Navigate to="/forbidden" />
  }

  return children
}
```

**Uso:**
```jsx
<ProtectedRoute requiredRole="admin">
  <AdminDashboard />
</ProtectedRoute>
```

### 2. Sidebar.jsx

**Propósito:** Menú de navegación lateral

**Características:**
- Navegación dinámica según rol
- Links activos resaltados
- Menú colapsable
- Responsive design

**Estructura:**
```javascript
export default function Sidebar() {
  const { user, logout } = useAuth()
  
  // Menús según rol del usuario
  const operatorMenus = [
    { label: 'Dashboard', path: '/dashboard', icon: '📊' },
    { label: 'Pacientes', path: '/pacientes', icon: '👥' },
    { label: 'Citas', path: '/citas', icon: '📅' },
    // ... más menús
  ]
  
  const adminMenus = [
    // ... todos los menús
  ]
  
  return (
    <aside className="sidebar">
      {/* Menú items */}
      {/* Logout button */}
    </aside>
  )
}
```

### 3. LoginView.jsx

**Propósito:** Componente de autenticación

**Flujo:**
1. Usuario ingresa credenciales
2. Validación local
3. Envío a backend via `authService.login()`
4. Almacenamiento de token JWT
5. Redirección a dashboard

**Estados manejados:**
- Loading
- Error
- Success
- Validations

### 4. AdminLayout.jsx

**Propósito:** Layout principal para usuarios autenticados

**Estructura:**
```
┌───────────────────────────────────┐
│          Barra Superior           │
├────────────────┬──────────────────┤
│                │                  │
│  Sidebar       │     Contenido    │
│  Navegación    │     Principal    │
│                │                  │
├────────────────┴──────────────────┤
│          Footer / Info            │
└───────────────────────────────────┘
```

### 5. HorarioSemanalPicker.jsx

**Propósito:** Selector de horarios semanales

**Características:**
- Calendario semanal
- Slots de tiempo disponibles
- Validación de horarios
- Visual interactivo

### 6. HorarioMensualPicker.jsx

**Propósito:** Vista mensual de disponibilidad

**Características:**
- Calendario mensual
- Indicadores de disponibilidad
- Navegación mes/año
- Resaltado de días disponibles

---

## 🔌 SERVICIOS Y APIS

### Estructura de Servicios

Cada módulo tiene su propio servicio que maneja las llamadas API:

```
services/
├── authService.js           # POST /login, POST /logout, POST /register
├── citasService.js          # CRUD de citas
├── pacientesService.js      # CRUD de pacientes
├── personalService.js       # CRUD de personal
├── especialidadesService.js # CRUD de especialidades
├── reportesService.js       # GET reportes
├── dashboardService.js      # GET estadísticas
└── usersService.js          # CRUD de usuarios
```

### Patrón Común de Servicio

```javascript
// Ejemplo: citasService.js
import api from '../api'

export const citasService = {
  // Listar citas
  getAll: async (filters = {}) => {
    try {
      const response = await api.get('/citas', { params: filters })
      return response.data
    } catch (error) {
      throw error.response?.data || error
    }
  },

  // Obtener una cita
  getById: async (id) => {
    const response = await api.get(`/citas/${id}`)
    return response.data
  },

  // Crear cita
  create: async (data) => {
    const response = await api.post('/citas', data)
    return response.data
  },

  // Actualizar cita
  update: async (id, data) => {
    const response = await api.put(`/citas/${id}`, data)
    return response.data
  },

  // Eliminar cita
  delete: async (id) => {
    const response = await api.delete(`/citas/${id}`)
    return response.data
  }
}

export default citasService
```

### api.js - Configuración Axios

```javascript
import axios from 'axios'

const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api'

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json'
  }
})

// Interceptor: Agregar token JWT
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => Promise.reject(error)
)

// Interceptor: Manejar errores
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Token expirado → Logout
      localStorage.removeItem('token')
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

export default api
```

---

## 🔐 AUTENTICACIÓN Y SEGURIDAD

### AuthContext.jsx

**Propósito:** Gestionar estado global de autenticación

```javascript
// Ubicación: src/contexts/AuthContext.jsx

import { createContext, useContext, useState, useEffect } from 'react'
import authService from '../services/authService'

const AuthContext = createContext()

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null)
  const [loading, setLoading] = useState(true)
  const [isAuthenticated, setIsAuthenticated] = useState(false)

  // Verificar token al cargar la app
  useEffect(() => {
    const token = localStorage.getItem('token')
    if (token) {
      validateToken(token)
    } else {
      setLoading(false)
    }
  }, [])

  const validateToken = async (token) => {
    try {
      const userData = await authService.validate(token)
      setUser(userData)
      setIsAuthenticated(true)
    } catch (error) {
      localStorage.removeItem('token')
      setIsAuthenticated(false)
    } finally {
      setLoading(false)
    }
  }

  const login = async (email, password) => {
    const data = await authService.login(email, password)
    localStorage.setItem('token', data.token)
    setUser(data.user)
    setIsAuthenticated(true)
    return data
  }

  const logout = () => {
    localStorage.removeItem('token')
    setUser(null)
    setIsAuthenticated(false)
  }

  return (
    <AuthContext.Provider value={{ user, loading, isAuthenticated, login, logout }}>
      {children}
    </AuthContext.Provider>
  )
}

export function useAuth() {
  return useContext(AuthContext)
}
```

### Flujo de Autenticación

```
1. Usuario intenta acceder
   ↓
2. ProtectedRoute verifica token
   ↓
3. Si no hay token → Redirige a Login
   ↓
4. Usuario ingresa credenciales
   ↓
5. authService.login() envía al backend
   ↓
6. Backend valida y retorna token JWT
   ↓
7. Token se almacena en localStorage
   ↓
8. User se actualiza en AuthContext
   ↓
9. Redirige a Dashboard
```

### Seguridad

**✅ Implementado:**
- ✅ Autenticación por JWT
- ✅ Token almacenado en localStorage (considerar sessionStorage)
- ✅ Interceptores para manejar tokens expirados
- ✅ Rutas protegidas por rol
- ✅ HTTPS recomendado en producción

**⚠️ Consideraciones:**
- Usar HTTPS en producción
- Considerar usar httpOnly cookies para tokens
- Implementar CORS correctamente
- Validar datos en cliente Y servidor
- Implementar rate limiting

---

## 🔄 GESTIÓN DE ESTADO

### Context API (Solución Actual)

El proyecto usa React Context API para gestión de estado global:

```javascript
// AuthContext - Autenticación global
- user: Objeto con datos del usuario actual
- isAuthenticated: Boolean de autenticación
- loading: Estado de carga
- login(): Función para autenticarse
- logout(): Función para cerrar sesión
```

### Flujo de Datos

```
Componente
    ↓
useAuth() hook
    ↓
AuthContext
    ↓
Estado Global
```

### Props Drilling vs Context

**Antes (Props Drilling):**
```jsx
<App user={user} logout={logout}>
  <Sidebar user={user} logout={logout}>
    <NavBar user={user} logout={logout}>
      <Profile user={user} logout={logout} />
    </NavBar>
  </Sidebar>
</App>
```

**Después (Context):**
```jsx
<AuthProvider>
  <App>
    <Sidebar>
      <NavBar>
        <Profile /> {/* Accede via useAuth() */}
      </NavBar>
    </Sidebar>
  </App>
</AuthProvider>
```

### Posibles Mejoras

Si la app crece, considerar:
- **Redux Toolkit:** Más estructurado, DevTools
- **Zustand:** Más ligero y simple
- **Recoil:** Atoms y selectors
- **Jotai:** Similar a Recoil

---

## 📍 RUTAS Y NAVEGACIÓN

### App.jsx - Configuración de Rutas

```javascript
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import { AuthProvider } from './contexts/AuthContext'
import ProtectedRoute from './components/ProtectedRoute'
import AdminLayout from './layouts/AdminLayout'
import LoginView from './views/LoginView'
import Welcome from './views/Welcome'
import Forbidden from './pages/Forbidden'
import Dashboard from './pages/Admin/Dashboard'
import Citas from './pages/Admin/Citas'
import Pacientes from './pages/Admin/Pacientes'
// ... más imports

export default function App() {
  return (
    <Router>
      <AuthProvider>
        <Routes>
          {/* Rutas públicas */}
          <Route path="/login" element={<LoginView />} />
          <Route path="/welcome" element={<Welcome />} />

          {/* Rutas protegidas */}
          <Route element={<AdminLayout />}>
            <Route path="/dashboard" element={
              <ProtectedRoute>
                <Dashboard />
              </ProtectedRoute>
            } />
            <Route path="/citas" element={
              <ProtectedRoute>
                <Citas />
              </ProtectedRoute>
            } />
            {/* ... más rutas */}
          </Route>

          {/* Errores */}
          <Route path="/forbidden" element={<Forbidden />} />
          <Route path="*" element={<NotFound />} />
        </Routes>
      </AuthProvider>
    </Router>
  )
}
```

### Tabla de Rutas

| Ruta | Componente | Protegida | Descripción |
|------|-----------|-----------|---|
| `/` | Welcome | No | Bienvenida |
| `/login` | LoginView | No | Login |
| `/dashboard` | Dashboard | Sí | Estadísticas |
| `/citas` | Citas | Sí | Gestión de citas |
| `/pacientes` | Pacientes | Sí | Gestión de pacientes |
| `/personal` | Personal | Sí | Gestión de personal |
| `/especialidades` | Especialidades | Sí | Gestión de especialidades |
| `/operadores` | Operadores | Sí | Gestión de operadores |
| `/usuarios` | Users | Sí | Gestión de usuarios |
| `/reportes` | Reportes | Sí | Reportes |
| `/archivados` | Archivados | Sí | Registros archivados |
| `/perfil` | Perfil | Sí | Mi perfil |
| `/forbidden` | Forbidden | Sí | Error 403 |
| `*` | NotFound | No | Error 404 |

---

## 🛠️ CONFIGURACIÓN DE DESARROLLO

### Instalación Local

```bash
# 1. Clonar repositorio
git clone <repository-url>
cd admision-medica_frontend

# 2. Instalar dependencias
npm install

# 3. Crear archivo .env
cp .env.example .env
# Editar .env con variables necesarias

# 4. Iniciar servidor de desarrollo
npm run dev

# Acceder a http://localhost:3000
```

### Variables de Entorno (.env)

```env
# API
REACT_APP_API_URL=http://localhost:8000/api
REACT_APP_API_TIMEOUT=30000

# Aplicación
REACT_APP_APP_NAME=Admisión Médica
REACT_APP_ENVIRONMENT=development

# Logging
REACT_APP_DEBUG=true
```

### Comandos Útiles

```bash
# Desarrollo
npm run dev              # Inicia servidor de desarrollo

# Producción
npm run build            # Compila para producción
npm run preview          # Previsualiza build de producción

# Calidad de código
npm run lint             # Ejecuta ESLint
npm run lint --fix       # Corrige problemas automáticamente

# Git
git status              # Estado de cambios
git add .               # Agregar cambios
git commit -m "Mensaje" # Commit
git push                # Enviar cambios
```

---

## 🚀 DEPLOYMENT

### Build para Producción

```bash
# 1. Build de optimización
npm run build

# Genera carpeta 'dist/' con archivos optimizados

# 2. Probar build localmente
npm run preview

# 3. Enviar a hosting
# Subir contenido de 'dist/' al servidor
```

### Opciones de Hosting

#### Option 1: Vercel (Recomendado)
```bash
npm install -g vercel
vercel login
vercel
```

#### Option 2: Netlify
```bash
npm install -g netlify-cli
netlify deploy --prod
```

#### Option 3: Docker
```dockerfile
# Dockerfile
FROM node:18-alpine as build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM nginx:alpine
COPY --from=build /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
```

```bash
# Build y ejecutar Docker
docker build -t admision-medica-frontend .
docker run -p 3000:80 admision-medica-frontend
```

#### Option 4: Servidor Linux (Apache/Nginx)

**Apache:**
```apache
<VirtualHost *:80>
    ServerName admision-medica.com
    DocumentRoot /var/www/html/admision-medica/dist
    <Directory /var/www/html/admision-medica/dist>
        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^ index.html [L]
    </Directory>
</VirtualHost>
```

**Nginx:**
```nginx
server {
    listen 80;
    server_name admision-medica.com;

    root /var/www/html/admision-medica/dist;
    index index.html;

    location / {
        try_files $uri $uri/ /index.html;
    }
}
```

---

## 🧪 TESTING

### Testing Frontend

#### Estructura Recomendada

```
src/
├── __tests__/
│   ├── components/
│   │   └── ProtectedRoute.test.jsx
│   ├── pages/
│   │   └── Dashboard.test.jsx
│   └── services/
│       └── authService.test.js
```

#### Ejemplo: Test de Componente

```javascript
// src/__tests__/components/ProtectedRoute.test.jsx
import { render, screen } from '@testing-library/react'
import { BrowserRouter } from 'react-router-dom'
import ProtectedRoute from '../../components/ProtectedRoute'
import { AuthProvider } from '../../contexts/AuthContext'

test('ProtectedRoute redirige a login si no está autenticado', () => {
  render(
    <BrowserRouter>
      <AuthProvider>
        <ProtectedRoute>
          <div>Contenido protegido</div>
        </ProtectedRoute>
      </AuthProvider>
    </BrowserRouter>
  )
  
  // Verificar que fue redirigido
  expect(screen.queryByText('Contenido protegido')).not.toBeInTheDocument()
})
```

#### Herramientas Recomendadas

```json
{
  "devDependencies": {
    "@testing-library/react": "^13.0.0",
    "@testing-library/jest-dom": "^5.0.0",
    "@testing-library/user-event": "^14.0.0",
    "vitest": "^0.30.0",
    "jsdom": "^21.0.0"
  }
}
```

---

## 🔧 TROUBLESHOOTING

### Problemas Comunes

#### 1. Error: "Cannot find module 'react'"

**Causa:** Dependencias no instaladas  
**Solución:**
```bash
npm install
# O limpiar node_modules
rm -rf node_modules package-lock.json
npm install
```

#### 2. Error: "Unexpected token" en JSX

**Causa:** Vite no configurado correctamente  
**Solución:**
```bash
# Verificar vite.config.js
# Asegurar que @vitejs/plugin-react está instalado
npm install @vitejs/plugin-react
```

#### 3. CORS errors: "Access to XMLHttpRequest blocked"

**Causa:** Backend no permite CORS  
**Solución en api.js:**
```javascript
const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json'
  },
  withCredentials: true // Para cookies
})
```

**Backend debe tener CORS habilitado:**
```
[Depende del framework backend - Ver manual backend]
```

#### 4. Token expirado en cada recarga

**Causa:** Token expira rápido o no se guarda bien  
**Solución:**
```javascript
// Usar sessionStorage en lugar de localStorage
const token = sessionStorage.getItem('token')
sessionStorage.setItem('token', data.token)
```

#### 5. Cambios no se reflejan en el navegador

**Causa:** Caché del navegador  
**Solución:**
```bash
# Limpiar caché y recargar
Ctrl+Shift+Delete (Windows)
Cmd+Shift+Delete (Mac)

# O en desarrollo
npm run dev # Reiniciar servidor
```

#### 6. "Cannot read property 'user' of undefined"

**Causa:** AuthContext no envuelve el componente  
**Solución:**
```jsx
// En App.jsx, envolver rutas con AuthProvider
<AuthProvider>
  <Routes>
    {/* ... */}
  </Routes>
</AuthProvider>
```

---

## 📚 DOCUMENTACIÓN ADICIONAL

### Recursos Útiles

**React:**
- [Documentación Oficial](https://react.dev)
- [React Router](https://reactrouter.com)
- [Context API Guide](https://react.dev/learn/passing-data-deeply-with-context)

**Vite:**
- [Vite Documentation](https://vitejs.dev)
- [Vite API Reference](https://vitejs.dev/config/)

**Axios:**
- [Axios Documentation](https://axios-http.com)
- [Interceptors Guide](https://axios-http.com/docs/interceptors)

**Seguridad:**
- [JWT.io](https://jwt.io)
- [OWASP Security](https://owasp.org)

---

## ✅ BACKEND - LARAVEL

### Stack Tecnológico Backend

| Tecnología | Versión | Propósito |
|-----------|---------|----------|
| **Laravel** | 11+ | Framework PHP |
| **PHP** | 8.2+ | Lenguaje base |
| **MySQL** | 8.0+ | Base de datos |
| **JWT (tymon/jwt-auth)** | 2.x | Autenticación |
| **Spatie Permissions** | 6.x | Control de roles |
| **Composer** | 2.x | Package manager |
| **Laravel Sanctum** | Built-in | API tokens |
| **Eloquent ORM** | Built-in | Manejo de BD |

### Estructura del Backend

```
admision-medica_backend/
│
├── app/
│   ├── Console/
│   │   ├── Commands/          # Comandos artisan personalizados
│   │   └── Kernel.php
│   │
│   ├── Http/
│   │   ├── Controllers/       # Controladores principales
│   │   │   ├── AuthController.php
│   │   │   ├── CitasController.php
│   │   │   ├── PacientesController.php
│   │   │   ├── PersonaSaludController.php
│   │   │   ├── EspecialidadesController.php
│   │   │   ├── OperadoresController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── UserProfileController.php
│   │   │   ├── ReporteController.php
│   │   │   └── UsersController.php
│   │   │
│   │   ├── Requests/         # Form Requests (Validaciones)
│   │   │   ├── StoreCitaRequest.php
│   │   │   ├── UpdateCitaRequest.php
│   │   │   ├── StorePacienteRequest.php
│   │   │   ├── UpdateProfileRequest.php
│   │   │   ├── ChangePasswordRequest.php
│   │   │   └── ...
│   │   │
│   │   ├── Middleware/       # Middleware personalizado
│   │   │   ├── Authenticate.php
│   │   │   ├── JwtMiddleware.php
│   │   │   └── CheckRole.php
│   │   │
│   │   └── Traits/           # Traits reutilizables
│   │       └── ApiResponse.php  # Respuestas JSON estándar
│   │
│   ├── Models/               # Modelos Eloquent
│   │   ├── User.php          # Usuario (Operadores, Supervisores)
│   │   ├── Cita.php          # Citas médicas
│   │   ├── Paciente.php      # Pacientes
│   │   ├── PersonalSalud.php # Personal médico
│   │   ├── Especialidad.php  # Especialidades
│   │   ├── Operador.php      # Operadores de admisión
│   │   └── Relaciones entre modelos
│   │
│   ├── Providers/
│   │   ├── AppServiceProvider.php  # Configuración app
│   │   └── AuthServiceProvider.php # Configuración auth
│   │
│   └── Exceptions/           # Manejo de excepciones
│       └── Handler.php
│
├── bootstrap/
│   ├── app.php               # Bootstrap de aplicación
│   ├── providers.php         # Providers cargados
│   └── cache/
│
├── config/                   # Configuración
│   ├── app.php              # Configuración general
│   ├── auth.php             # Configuración autenticación
│   ├── database.php         # Conexión BD
│   ├── jwt.php              # Configuración JWT
│   ├── cors.php             # Configuración CORS
│   ├── mail.php             # Configuración correo
│   └── permission.php       # Configuración roles
│
├── database/
│   ├── migrations/          # Migraciones (Creación de tablas)
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_04_16_010118_create_pacientes_table.php
│   │   ├── 2026_04_16_010200_create_operadores_table.php
│   │   ├── 2026_04_16_010208_create_personal_salud_table.php
│   │   ├── 2026_04_16_010233_create_citas_table.php
│   │   ├── 2026_06_05_000000_add_fields_to_users_table.php
│   │   ├── 2026_06_06_000000_add_index_to_citas_table.php
│   │   └── ... más migraciones
│   │
│   ├── factories/           # Factories para testing
│   │   └── UserFactory.php
│   │
│   └── seeders/             # Seeders (Data de prueba)
│       ├── DatabaseSeeder.php
│       └── CreateSupervisorUser.php
│
├── routes/
│   ├── api.php              # Rutas API (Protegidas con middleware)
│   ├── web.php              # Rutas web (No usadas actualmente)
│   └── console.php          # Rutas de comandos
│
├── storage/
│   ├── app/                 # Almacenamiento de archivos
│   ├── framework/           # Cache y sesiones
│   └── logs/                # Logs de aplicación
│
├── tests/
│   ├── Feature/             # Tests de features/endpoints
│   ├── Unit/                # Tests unitarios
│   └── TestCase.php         # Clase base de tests
│
├── vendor/                  # Dependencias Composer
│
├── .env                     # Variables de entorno
├── .env.example             # Ejemplo de .env
├── artisan                  # CLI de Laravel
├── composer.json            # Dependencias
├── composer.lock            # Lock de dependencias
├── docker-compose.yml       # Docker compose
├── Dockerfile               # Docker config
├── phpunit.xml              # Config PHPUnit
├── README.md
└── MANUAL_TECNICO.md        # Este archivo
```

### Modelos de Datos

#### User.php
```php
// app/Models/User.php
class User extends Authenticatable implements JWTSubject {
    protected $fillable = [
        'name',          // Nombre completo
        'apellido',      // Apellido
        'email',         // Email único
        'password',      // Contraseña (hash)
        'telefono',      // Teléfono
    ];

    // Relaciones
    public function operador() {
        return $this->hasOne(Operador::class, 'user_id');
    }

    // JWT Implementation
    public function getJWTIdentifier() { }
    public function getJWTCustomClaims() { }
}
```

**Tabla SQL:**
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    apellido VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    telefono VARCHAR(20),
    email_verified_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### Cita.php
```php
// app/Models/Cita.php
class Cita extends Model {
    protected $fillable = [
        'paciente_id',       // FK → Paciente
        'personal_salud_id', // FK → PersonalSalud
        'especialidad_id',   // FK → Especialidad
        'fecha',             // Fecha de cita
        'hora',              // Hora (HH:MM)
        'estado',            // Pendiente, Completada, Cancelada
        'nro_ticket',        // Número de ticket POR ESPECIALIDAD
        'total_tickets_dia', // Cupo máximo por día
        'observaciones',     // Notas adicionales
        'operador_id',       // FK → User (quien crea)
    ];

    // Relaciones
    public function paciente() { return $this->belongsTo(Paciente::class); }
    public function personalSalud() { return $this->belongsTo(PersonalSalud::class); }
    public function especialidad() { return $this->belongsTo(Especialidad::class); }
    public function operador() { return $this->belongsTo(Operador::class); }
}
```

**Tabla SQL:**
```sql
CREATE TABLE citas (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    paciente_id BIGINT UNSIGNED,
    personal_salud_id BIGINT UNSIGNED,
    especialidad_id BIGINT UNSIGNED,
    fecha DATE,
    hora TIME,
    estado VARCHAR(50) DEFAULT 'Pendiente',
    nro_ticket INTEGER,
    total_tickets_dia INTEGER DEFAULT 16,
    observaciones TEXT,
    operador_id BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (personal_salud_id) REFERENCES personal_salud(id),
    FOREIGN KEY (especialidad_id) REFERENCES especialidades(id),
    FOREIGN KEY (operador_id) REFERENCES users(id),
    
    INDEX idx_fecha_especialidad (fecha, especialidad_id)
);
```

#### Paciente.php
```php
// app/Models/Paciente.php
class Paciente extends Model {
    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'tipo_documento',    // DNI, Pasaporte, etc
        'email',
        'telefono',
        'direccion',
        'etapa_vida',        // Niño, Adulto, Mayor
        'gestante',          // true/false
        'detalle_gestante',  // Descripción si es gestante
        'HistoriaClinica',   // Código único de historia clínica
        'estado',            // Activo/Inactivo
    ];

    // Relaciones
    public function citas() { return $this->hasMany(Cita::class); }
}
```

#### PersonalSalud.php
```php
// app/Models/PersonalSalud.php
class PersonalSalud extends Model {
    protected $fillable = [
        'nombres',
        'apellidos',
        'especialidad_id',   // FK → Especialidad
        'codigo',            // Código empleado
        'email',
        'estado',
    ];

    // Relaciones
    public function especialidad() { return $this->belongsTo(Especialidad::class); }
    public function citas() { return $this->hasMany(Cita::class); }
}
```

### Controladores Principales

#### AuthController.php
```php
// app/Http/Controllers/AuthController.php
class AuthController extends Controller {
    use ApiResponse;

    /**
     * POST /api/login
     * Autenticar usuario
     */
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->error('Credenciales inválidas', 401);
        }

        return $this->success([
            'user' => auth('api')->user(),
            'token' => $token
        ], 'Login exitoso');
    }

    /**
     * POST /api/logout
     * Cerrar sesión
     */
    public function logout() {
        auth('api')->logout();
        return $this->success(null, 'Logout exitoso');
    }

    /**
     * POST /api/refresh
     * Refrescar token
     */
    public function refresh() {
        $token = auth('api')->refresh();
        return $this->success(['token' => $token]);
    }
}
```

#### CitasController.php
```php
// app/Http/Controllers/CitasController.php
class CitasController extends Controller {
    use ApiResponse;

    /**
     * GET /api/citas
     * Listar citas con filtros
     * 
     * Filtros soportados:
     * - search: busca en nombre/apellido/DNI del paciente
     * - estado: filtra por estado (pendiente, completada, cancelada)
     * - especialidad_id: filtra por especialidad
     * - fecha: filtra por fecha (YYYY-MM-DD)
     * - personal_salud_id: filtra por médico
     * - per_page: registros por página (default 20)
     */
    public function index(Request $request) {
        $query = Cita::with(['paciente', 'personalSalud', 'operador', 'especialidad'])
            ->leftJoin('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
            ->select('citas.*');

        // Filtros aplicados...
        return $this->success($query->paginate(20));
    }

    /**
     * GET /api/citas/next-ticket
     * Obtener siguiente número de ticket por especialidad
     * 
     * Parámetros requeridos:
     * - fecha: YYYY-MM-DD
     * - especialidad_id: ID de especialidad
     * - cupo: máximo de tickets (default 16)
     */
    public function getNextTicket(Request $request) {
        $maxTicket = Cita::whereDate('fecha', $request->fecha)
            ->where('especialidad_id', $request->especialidad_id)
            ->max('nro_ticket');

        return $this->success([
            'next_ticket' => ($maxTicket ?? 0) + 1,
            'total_tickets_dia' => $request->query('cupo', 16),
            'especialidad_id' => $request->especialidad_id
        ]);
    }

    /**
     * POST /api/citas
     * Crear nueva cita
     * 
     * Validaciones:
     * - especialidad_id requerido (FK válido)
     * - fecha requerida (date)
     * - hora requerida (time)
     * - paciente_id requerido (FK válido)
     * - personal_salud_id opcional
     */
    public function store(StoreCitaRequest $request) {
        $data = $request->validated();

        // Tickets independientes por especialidad y fecha
        $maxTicket = Cita::whereDate('fecha', $data['fecha'])
            ->where('especialidad_id', $data['especialidad_id'])
            ->max('nro_ticket');

        $siguienteTicket = ($maxTicket ?? 0) + 1;
        $cupo = $data['total_tickets_dia'] ?? 16;

        if ($siguienteTicket > $cupo) {
            return $this->error(
                "Cupo máximo alcanzado ({$cupo}) para esta especialidad",
                422
            );
        }

        $data['nro_ticket'] = $siguienteTicket;
        $data['operador_id'] = auth('api')->id();

        $cita = Cita::create($data);
        return $this->success($cita, 'Cita creada - Ticket #' . $siguienteTicket, 201);
    }

    /**
     * PUT /api/citas/{id}
     * Actualizar cita
     * 
     * Si cambia especialidad o fecha, recalcula el ticket automáticamente
     */
    public function update(UpdateCitaRequest $request, $id) {
        $cita = Cita::find($id);
        if (!$cita) return $this->error('No encontrado', 404);

        $data = $request->validated();

        // Recalcular ticket si cambió especialidad o fecha
        if ($request->has('especialidad_id') || $request->has('fecha')) {
            $fecha = $request->fecha ?? $cita->fecha;
            $especialidad_id = $request->especialidad_id ?? $cita->especialidad_id;

            $maxTicket = Cita::whereDate('fecha', $fecha)
                ->where('especialidad_id', $especialidad_id)
                ->where('id', '!=', $cita->id)
                ->max('nro_ticket');

            $data['nro_ticket'] = ($maxTicket ?? 0) + 1;
        }

        $cita->update($data);
        return $this->success($cita, 'Cita actualizada');
    }
}
```

#### UserProfileController.php
```php
// app/Http/Controllers/UserProfileController.php
class UserProfileController extends Controller {
    use ApiResponse;

    /**
     * GET /api/user/profile
     * Obtener perfil del usuario autenticado
     */
    public function show(Request $request) {
        $user = auth('api')->user();
        return $this->success([
            'id' => $user->id,
            'name' => $user->name,
            'apellido' => $user->apellido,
            'email' => $user->email,
            'telefono' => $user->telefono,
        ]);
    }

    /**
     * PUT /api/user/profile
     * Actualizar perfil del usuario
     * 
     * Validaciones:
     * - name: obligatorio
     * - email: válido y único (excepto el actual)
     * - apellido, telefono: opcionales
     */
    public function update(UpdateProfileRequest $request) {
        $user = auth('api')->user();
        $user->update($request->validated());
        return $this->success($user, 'Perfil actualizado');
    }

    /**
     * POST /api/user/change-password
     * Cambiar contraseña del usuario
     * 
     * Parámetros:
     * - current_password: contraseña actual
     * - new_password: nueva contraseña (mín 8 caracteres)
     */
    public function changePassword(ChangePasswordRequest $request) {
        $user = auth('api')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->error('Contraseña actual incorrecta', 400);
        }

        $user->update(['password' => Hash::make($request->new_password)]);
        return $this->success(null, 'Contraseña actualizada');
    }
}
```

### Validaciones (Form Requests)

#### StoreCitaRequest.php
```php
// app/Http/Requests/StoreCitaRequest.php
class StoreCitaRequest extends FormRequest {
    public function authorize(): bool {
        return auth('api')->check();
    }

    public function rules(): array {
        return [
            'paciente_id' => 'required|exists:pacientes,id',
            'especialidad_id' => 'required|exists:especialidades,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'personal_salud_id' => 'nullable|exists:personal_salud,id',
            'estado' => 'nullable|in:Pendiente,Completada,Cancelada',
            'total_tickets_dia' => 'nullable|integer|min:1|max:100',
            'observaciones' => 'nullable|string|max:1000',
        ];
    }
}
```

### Rutas API

```php
// routes/api.php
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    // Endpoints de perfil
    Route::get('user/profile', [UserProfileController::class, 'show']);
    Route::put('user/profile', [UserProfileController::class, 'update']);
    Route::post('user/change-password', [UserProfileController::class, 'changePassword']);

    // Endpoints protegidos por rol
    Route::group(['middleware' => ['role:operador|supervisor']], function () {
        Route::get('dashboard/stats', [DashboardController::class, 'stats']);
        Route::get('citas/next-ticket', [CitasController::class, 'getNextTicket']);
        Route::apiResource('citas', CitasController::class);
        Route::apiResource('pacientes', PacientesController::class);
        Route::apiResource('personal_salud', PersonaSaludController::class);
        Route::apiResource('especialidades', EspecialidadesController::class);
        Route::apiResource('operadores', OperadoresController::class);
        Route::get('reportes/personal', [ReporteController::class, 'index']);
    });
});
```

### Autenticación JWT

#### Configuración (config/jwt.php)
```php
'secret' => env('JWT_SECRET'),
'ttl' => 60,                    // Token expira en 60 minutos
'refresh_ttl' => 20160,         // Refresh token 14 días
'algorithm' => 'HS256',         // Algoritmo de firma
```

#### Generación de Token
```php
// En login
$token = auth('api')->attempt($credentials);
// Token se genera automáticamente via JWT

// En logout
auth('api')->logout();
// Token se invalida

// En refresh
$newToken = auth('api')->refresh();
// Genera nuevo token
```

### Manejo de Errores

#### ApiResponse Trait
```php
// app/Http/Controllers/Traits/ApiResponse.php
trait ApiResponse {
    public function success($data = null, $message = 'Operación exitosa', $code = 200) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error($message = 'Error', $code = 400, $details = []) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $details
        ], $code);
    }
}
```

### Base de Datos

#### Migraciones Principales
```bash
# Ejecutar todas las migraciones
php artisan migrate

# Crear nueva migración
php artisan make:migration create_tabla_name

# Rollback (deshacer)
php artisan migrate:rollback

# Rollback todo
php artisan migrate:reset
```

#### Seeders (Data de prueba)
```bash
# Ejecutar seeders
php artisan db:seed

# Seed específico
php artisan db:seed --class=CreateSupervisorUser

# Seed en producción (con confirmación)
php artisan db:seed --force
```

### Instalación y Configuración

#### 1. Instalación Local
```bash
# 1. Clonar repositorio
git clone <repository-url>
cd admision-medica_backend

# 2. Instalar dependencias
composer install

# 3. Crear archivo .env
cp .env.example .env

# 4. Generar clave de aplicación
php artisan key:generate

# 5. Generar JWT secret
php artisan jwt:secret

# 6. Migrar base de datos
php artisan migrate

# 7. Sembrar datos de prueba
php artisan db:seed

# 8. Iniciar servidor
php artisan serve
# Acceder a http://localhost:8000
```

#### Variables de Entorno (.env)
```env
APP_NAME="Admisión Médica"
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admision_medica
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=your-secret-key-here
JWT_ALGORITHM=HS256
JWT_TTL=60

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
```

### Deployment

#### Docker
```dockerfile
# Dockerfile
FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    mysql-client \
    zip \
    git \
    && docker-php-ext-install pdo_mysql

WORKDIR /app

COPY --chown=www-data:www-data . .

RUN composer install --no-dev --optimize-autoloader

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
```

```bash
# Build y ejecutar
docker build -t admision-medica-backend .
docker run -p 8000:8000 \
  -e DB_HOST=host.docker.internal \
  admision-medica-backend
```

#### Docker Compose
```yaml
# docker-compose.yml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      DB_HOST: mysql
      DB_USERNAME: root
      DB_PASSWORD: password
      DB_DATABASE: admision_medica
    depends_on:
      - mysql

  mysql:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: admision_medica
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql

volumes:
  mysql_data:
```

```bash
# Ejecutar stack
docker-compose up -d
```

### Testing

```bash
# Ejecutar todos los tests
php artisan test

# Test específico
php artisan test tests/Feature/CitasTest.php

# Con cobertura
php artisan test --coverage

# Test unitario
php artisan test tests/Unit/
```

### Troubleshooting Backend

#### 1. Error "No application encryption key has been specified"
```bash
php artisan key:generate
```

#### 2. Error "JWT secret has not been set"
```bash
php artisan jwt:secret
```

#### 3. Error "Class does not exist"
```bash
composer dump-autoload
php artisan optimize:clear
```

#### 4. CORS errors
Verificar `config/cors.php`:
```php
'allowed_origins' => ['http://localhost:3000'],
'supports_credentials' => true,
```

#### 5. Base de datos no conecta
```bash
# Verificar credenciales .env
# Verificar MySQL está corriendo
# Re-migrar
php artisan migrate:fresh
```

### Performance

#### Optimizaciones Implementadas
- ✅ Índices compuestos en tablas principales
- ✅ Eager loading de relaciones (with)
- ✅ Paginación de resultados
- ✅ Caché de configuración
- ✅ JWT para stateless auth

#### Posibles Mejoras
- Implementar Redis para caché
- Query optimization con EXPLAIN
- Rate limiting en endpoints
- Compression de respuestas
- CDN para archivos estáticos

### Comandos Útiles Artisan

```bash
php artisan list                      # Ver todos los comandos
php artisan tinker                    # REPL interactivo
php artisan migrate                   # Ejecutar migraciones
php artisan make:model Nombre         # Crear modelo
php artisan make:controller Nombre    # Crear controlador
php artisan make:request Nombre       # Crear form request
php artisan make:migration Nombre     # Crear migración
php artisan config:cache             # Cachar configuración
php artisan route:cache              # Cachar rutas
php artisan optimize:clear           # Limpiar caché
```

---

## � HISTORIAL DE CAMBIOS

| Versión | Fecha | Estado | Cambios |
|---------|-------|--------|---------|
| 1.0 | Junio 2026 | ✅ Completado | Frontend documentado completamente |
| 2.0 | Junio 2026 | ✅ Completado | Backend (Laravel) documentado completamente |

---

## 📝 NOTAS FINALES

✅ **Manual Técnico Completo**

Este manual cubre:
- ✅ Arquitectura full-stack
- ✅ Stack tecnológico frontend y backend
- ✅ Estructura de carpetas y organización
- ✅ Componentes y servicios frontend
- ✅ Controladores y modelos backend
- ✅ Autenticación JWT
- ✅ Validaciones y manejo de errores
- ✅ Deployment en desarrollo y producción
- ✅ Testing
- ✅ Troubleshooting
- ✅ Performance optimization

---

## 🔗 REFERENCIAS RÁPIDAS

### Enlaces Importantes

**Repositorios:**
- Frontend: `admision-medica_frontend/`
- Backend: `admision-medica_backend/`

**Servidores de Desarrollo:**
- Frontend: `http://localhost:3000`
- Backend: `http://localhost:8000`

**Endpoints Principales:**
- Auth: `POST /api/login`
- Citas: `GET/POST/PUT/DELETE /api/citas`
- Pacientes: `GET/POST/PUT/DELETE /api/pacientes`
- Perfil: `GET/PUT /api/user/profile`

**Base de Datos:**
- Host: `localhost:3306`
- Base: `admision_medica`
- Usuario: `root`

---

## 📞 SOPORTE Y CONTACTO

Para dudas o problemas técnicos, consultar:
- Equipo Frontend: frontend-dev@admision-medica.com
- Equipo Backend: backend-dev@admision-medica.com
- DevOps: devops@admision-medica.com

---

**© 2026 Sistema de Admisión Médica - Manual Técnico Completo**

**Última actualización:** Junio 2026  
**Estado:** ✅ COMPLETO (Frontend + Backend)  
**Clasificación:** Técnico - Confidencial  
**Versión:** 2.0

---

## ✨ NOTA FINAL

Este manual técnico proporciona documentación completa de:
- ✅ Arquitectura full-stack
- ✅ Frontend con React + Vite
- ✅ Backend con Laravel + JWT
- ✅ Autenticación y seguridad
- ✅ Base de datos y migraciones
- ✅ Deployment y DevOps
- ✅ Testing y quality assurance
- ✅ Performance y optimization
- ✅ Troubleshooting

**Para preguntas técnicas, contactar con el equipo correspondiente según el componente.**

---
