<div align="center">
    <h1>TSW</h1>
    <h3>🌐 Tecnologías y Servicios Web 🌐</h3>
</div>

## 📝 TODO

### Entrega TikTak

- [ ] Subir vídeos
  - [ ] Comprobar si es un vídeo
  - [ ] Guardar vídeos dentro de `api/v/` con formato de nombre `md5(titulo)`
  - [ ] Usar `fetch` para comunicarse con la API
  - [ ] Crear endpoint `POST /api/v1/video`
- [ ] Crear Vistas
  - [ ] Home del usuario con los ultimos videos: Actualizar el estado del Timeline con el resultado de `GET /api/v1/videos` ( SELECT ID, user, title, sharedtimes FROM videos ORDER BY upload_date )
  - [ ] Trending con los videos más famosos: Actualizar el estado del Timeline con el resultado de `GET /api/v1/videos/trending` ( SELECT ID, user, title, sharedtimes FROM videos ORDER BY sharedtimes -- por ejemplo, aunque mejor si se hace con likes)
- [ ] Arreglar traducciones de los modales
- [ ] Implementar like
- [ ] Implementar comentarios (de último)
- [ ] Implementar compartir
