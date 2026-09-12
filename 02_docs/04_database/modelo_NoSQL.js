// ==============================================================================
// MOCK DATA PARA MONGODB (COLECCIÓN: envios)
// Compatibilidad: MongoDB 4.4+ / Mongo Shell (mongosh)
// Script para insertar 15 documentos completos de rastreo de envíos.
// ==============================================================================

use giganet_nosql;

db.envios.drop(); // Limpieza inicial si existe la colección

db.envios.insertMany([
  {
    "_id": ObjectId("665123456789abcdef012301"),
    "id_venta_mysql": 1,
    "no_cotizacion": "COT-20260810-091500",
    "no_factura": "FEL-000101",
    "empresa_transporte": "Cargo Expreso",
    "numero_guia": "CX-2026-8801",
    "tipo_envio": "Entrega a Domicilio",
    "costo_envio": 45.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "10",
      "direccion_exacta": "Av. La Reforma 12-01, Edificio Reforma Montúfar",
      "referencias": "Oficina 402, Nivel 4"
    },
    "destinatario": {
      "nombre_completo": "Sistemas e Innovaciones de Guatemala",
      "contacto_recepcion": "Ing. Mario Estrada",
      "telefono": "2334-5678",
      "email_notificacion": "compras@sigsa.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 6.8,
      "bultos": 2,
      "alto_cm": 25,
      "ancho_cm": 40,
      "profundidad_cm": 30
    },
    "historial_rastreo": [
      {
        "estado": "Preparado en Bodega",
        "fecha": ISODate("2026-08-10T11:00:00Z"),
        "ubicacion": "Bodega Central Giganet - Zona 11",
        "comentario": "Mercancía empacada y verificada contra factura FEL-000101"
      },
      {
        "estado": "Recolectado por Transporte",
        "fecha": ISODate("2026-08-10T14:30:00Z"),
        "ubicacion": "Bodega Central Giganet",
        "comentario": "Piloto de Cargo Expreso recaba paquetes"
      },
      {
        "estado": "En Ruta de Entrega",
        "fecha": ISODate("2026-08-11T08:15:00Z"),
        "ubicacion": "Centro de Distribución Cargo Expreso Z12",
        "comentario": "Asignado a ruta metropolitana 4"
      },
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-08-11T11:40:00Z"),
        "ubicacion": "Recepción SIGSA - Zona 10",
        "comentario": "Recibido a satisfacción por Mario Estrada"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-08-11T11:40:00Z"),
      "recibido_por": "Mario Estrada",
      "documento_dpi": "2345 12345 0101",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/CX-2026-8801_firma.png",
      "foto_evidencia_url": "https://storage.giganet.com.gt/fotos/guias/CX-2026-8801_entrega.jpg"
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012302"),
    "id_venta_mysql": 2,
    "no_cotizacion": "COT-20260812-113022",
    "no_factura": "FEL-000102",
    "empresa_transporte": "Guatex",
    "numero_guia": "GTX-774910",
    "tipo_envio": "Envío Departamental",
    "costo_envio": 65.00,
    "direccion_destino": {
      "departamento": "Quetzaltenango",
      "municipio": "Quetzaltenango",
      "zona": "1",
      "direccion_exacta": "5ta Calle 3-12",
      "referencias": "Frente al Parque Centroamérica"
    },
    "destinatario": {
      "nombre_completo": "Telecomunicaciones del Norte",
      "contacto_recepcion": "Roberto Calderón",
      "telefono": "7761-1234",
      "email_notificacion": "mantenimiento@telcenor.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 12.5,
      "bultos": 1,
      "alto_cm": 15,
      "ancho_cm": 48,
      "profundidad_cm": 44
    },
    "historial_rastreo": [
      {
        "estado": "Preparado en Bodega",
        "fecha": ISODate("2026-08-12T15:00:00Z"),
        "ubicacion": "Bodega Central Giganet",
        "comentario": "Switch empacado en caja reforzada"
      },
      {
        "estado": "En Tránsito Interdepartamental",
        "fecha": ISODate("2026-08-13T04:00:00Z"),
        "ubicacion": "Carretera Interamericana Km 140",
        "comentario": "Unidad de transporte de carga Guatex"
      },
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-08-13T15:20:00Z"),
        "ubicacion": "Oficinas Telcenor - Xela",
        "comentario": "Firmado por Roberto Calderón"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-08-13T15:20:00Z"),
      "recibido_por": "Roberto Calderón",
      "documento_dpi": "1980 98765 0901",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/GTX-774910_firma.png",
      "foto_evidencia_url": "https://storage.giganet.com.gt/fotos/guias/GTX-774910_entrega.jpg"
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012303"),
    "id_venta_mysql": 3,
    "no_cotizacion": "COT-20260815-142010",
    "no_factura": "FEL-000103",
    "empresa_transporte": "Transporte Propio Giganet",
    "numero_guia": "INT-2026-0042",
    "tipo_envio": "Entrega Directa Express",
    "costo_envio": 0.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "10",
      "direccion_exacta": "18 Calle 5-45, Pradera Concejo",
      "referencias": "Torre B, Nivel 8"
    },
    "destinatario": {
      "nombre_completo": "Redes y Ciberseguridad Integral",
      "contacto_recepcion": "Licda. Andrea Paiz",
      "telefono": "2410-9900",
      "email_notificacion": "info@redsecur.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 8.0,
      "bultos": 1
    },
    "historial_rastreo": [
      {
        "estado": "Despachado de Bodega",
        "fecha": ISODate("2026-08-15T16:30:00Z"),
        "ubicacion": "Bodega Central Giganet",
        "comentario": "Asignado a piloto interno Panel #2"
      },
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-08-15T17:45:00Z"),
        "ubicacion": "Redes y Ciberseguridad Z10",
        "comentario": "Entrega directa realizada por el piloto Jorge Pérez"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-08-15T17:45:00Z"),
      "recibido_por": "Andrea Paiz",
      "documento_dpi": "1650 44332 0101",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/INT-2026-0042_firma.png",
      "foto_evidencia_url": "https://storage.giganet.com.gt/fotos/guias/INT-2026-0042_entrega.jpg"
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012304"),
    "id_venta_mysql": 4,
    "no_cotizacion": "COT-20260818-160545",
    "no_factura": "FEL-000104",
    "empresa_transporte": "Cargo Expreso",
    "numero_guia": "CX-2026-9012",
    "tipo_envio": "Entrega a Domicilio",
    "costo_envio": 50.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "10",
      "direccion_exacta": "Bulevar Los Próceres 24-69",
      "referencias": "Garita principal de recepción de materiales"
    },
    "destinatario": {
      "nombre_completo": "Constructora El Roble",
      "contacto_recepcion": "Ing. Gustavo Santos",
      "telefono": "2200-4400",
      "email_notificacion": "logistica@elroble.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 28.0,
      "bultos": 2
    },
    "historial_rastreo": [
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-08-19T10:15:00Z"),
        "ubicacion": "Proyecto El Roble",
        "comentario": "Recibido por bodeguero de obra"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-08-19T10:15:00Z"),
      "recibido_por": "Gustavo Santos",
      "documento_dpi": "2100 55667 0101",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/CX-2026-9012_firma.png",
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012305"),
    "id_venta_mysql": 5,
    "no_cotizacion": "COT-20260820-101200",
    "no_factura": "FEL-000105",
    "empresa_transporte": "Transporte Propio Giganet",
    "numero_guia": "INT-2026-0055",
    "tipo_envio": "Entrega Especial sobre Pallet",
    "costo_envio": 0.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "10",
      "direccion_exacta": "Diagonal 6 10-50, Las Margaritas",
      "referencias": "Torre II, Nivel 12"
    },
    "destinatario": {
      "nombre_completo": "Soluciones Tecnológicas Integradas",
      "contacto_recepcion": "Ing. Fernando Morales",
      "telefono": "2380-1122",
      "email_notificacion": "ventas@soltecin.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 15.0,
      "bultos": 10
    },
    "historial_rastreo": [
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-08-20T15:00:00Z"),
        "ubicacion": "Las Margaritas Z10",
        "comentario": "Entrega completada de 10 Access Points UniFi"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-08-20T15:00:00Z"),
      "recibido_por": "Fernando Morales",
      "documento_dpi": "2200 11223 0101",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/INT-2026-0055_firma.png",
      "foto_evidencia_url": "https://storage.giganet.com.gt/fotos/guias/INT-2026-0055_entrega.jpg"
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012306"),
    "id_venta_mysql": 6,
    "no_cotizacion": "COT-20260822-084530",
    "no_factura": "FEL-000106",
    "empresa_transporte": "Transporte de Carga Amatitlán",
    "numero_guia": "TCA-2026-1102",
    "tipo_envio": "Envío de Carga Pesada",
    "costo_envio": 120.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Amatitlán",
      "zona": "0",
      "direccion_exacta": "Km 28.5 Carretera a Amatitlán",
      "referencias": "Planta Industrial Liztex"
    },
    "destinatario": {
      "nombre_completo": "Corporación Textil Liztex, S.A.",
      "contacto_recepcion": "Asistencia de Producción",
      "telefono": "6630-8800",
      "email_notificacion": "sistemas@liztex.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 45.0,
      "bultos": 3
    },
    "historial_rastreo": [
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-08-22T14:20:00Z"),
        "ubicacion": "Bodega de Insumos Liztex Amatitlán",
        "comentario": "Recibido por control de calidad"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-08-22T14:20:00Z"),
      "recibido_por": "Julio Arriola",
      "documento_dpi": "1890 33211 0108",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/TCA-2026-1102_firma.png",
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012307"),
    "id_venta_mysql": 7,
    "no_cotizacion": "COT-20260825-153012",
    "no_factura": "FEL-000107",
    "empresa_transporte": "Guatex",
    "numero_guia": "GTX-880192",
    "tipo_envio": "Envío Departamental",
    "costo_envio": 40.00,
    "direccion_destino": {
      "departamento": "Sacatepéquez",
      "municipio": "Antigua Guatemala",
      "zona": "0",
      "direccion_exacta": "Calle del Arco No. 15",
      "referencias": "Local Comercial San José"
    },
    "destinatario": {
      "nombre_completo": "Comercializadora San José",
      "contacto_recepcion": "Doña Marta San José",
      "telefono": "7832-0011",
      "email_notificacion": "compras@sanjose.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 5.2,
      "bultos": 1
    },
    "historial_rastreo": [
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-08-26T11:00:00Z"),
        "ubicacion": "Antigua Guatemala",
        "comentario": "Entrega efectuada exitosamente"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-08-26T11:00:00Z"),
      "recibido_por": "Marta San José",
      "documento_dpi": "1200 99887 0301",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/GTX-880192_firma.png",
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012308"),
    "id_venta_mysql": 8,
    "no_cotizacion": "COT-20260828-110000",
    "no_factura": "FEL-000108",
    "empresa_transporte": "Cargo Expreso",
    "numero_guia": "CX-2026-9400",
    "tipo_envio": "Entrega a Domicilio",
    "costo_envio": 35.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "9",
      "direccion_exacta": "7a Avenida 14-44, Plaza Corporativa",
      "referencias": "Oficina 301"
    },
    "destinatario": {
      "nombre_completo": "NetData Comunicaciones S.A.",
      "contacto_recepcion": "Ing. Carlos López",
      "telefono": "2250-7788",
      "email_notificacion": "soporte@netdata.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 6.0,
      "bultos": 2
    },
    "historial_rastreo": [
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-08-29T09:40:00Z"),
        "ubicacion": "NetData Z9",
        "comentario": "Entrega de biométricos"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-08-29T09:40:00Z"),
      "recibido_por": "Carlos López",
      "documento_dpi": "2310 88776 0101",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/CX-2026-9400_firma.png",
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012309"),
    "id_venta_mysql": 9,
    "no_cotizacion": "COT-20260901-092211",
    "no_factura": "FEL-000109",
    "empresa_transporte": "Transporte Propio Giganet",
    "numero_guia": "INT-2026-0062",
    "tipo_envio": "Entrega Especial Médica",
    "costo_envio": 0.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "11",
      "direccion_exacta": "6ta Avenida 3-22, Roosevelt",
      "referencias": "Recepción de Gerencia de IT"
    },
    "destinatario": {
      "nombre_completo": "Hospital San Francisco",
      "contacto_recepcion": "Dr. Sergio Ramos",
      "telefono": "2323-9000",
      "email_notificacion": "it@sanfrancisco.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 24.0,
      "bultos": 2
    },
    "historial_rastreo": [
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-09-01T14:00:00Z"),
        "ubicacion": "Hospital San Francisco Z11",
        "comentario": "UPS instalados en rack de servidores"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-09-01T14:00:00Z"),
      "recibido_por": "Sergio Ramos",
      "documento_dpi": "1500 22334 0101",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/INT-2026-0062_firma.png",
      "foto_evidencia_url": "https://storage.giganet.com.gt/fotos/guias/INT-2026-0062_entrega.jpg"
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012310"),
    "id_venta_mysql": 10,
    "no_cotizacion": null,
    "no_factura": "FEL-000110",
    "empresa_transporte": "Guatex",
    "numero_guia": "GTX-990123",
    "tipo_envio": "Envío Departamental Express",
    "costo_envio": 75.00,
    "direccion_destino": {
      "departamento": "Huehuetenango",
      "municipio": "Huehuetenango",
      "zona": "3",
      "direccion_exacta": "4ta Calle 8-19",
      "referencias": "Oficinas Cable Redes"
    },
    "destinatario": {
      "nombre_completo": "Cable Redes de Occidente",
      "contacto_recepcion": "Manuel Gómez",
      "telefono": "7765-4321",
      "email_notificacion": "operaciones@cableredes.gt"
    },
    "estado_actual": "En Tránsito",
    "dimensiones_paquete": {
      "peso_kg": 4.2,
      "bultos": 1
    },
    "historial_rastreo": [
      {
        "estado": "Preparado en Bodega",
        "fecha": ISODate("2026-09-03T12:00:00Z"),
        "ubicacion": "Bodega Central Giganet",
        "comentario": "Empacado y listo"
      },
      {
        "estado": "Recolectado por Transporte",
        "fecha": ISODate("2026-09-03T16:00:00Z"),
        "ubicacion": "Centro de Acopio Guatex Z11",
        "comentario": "En ruta hacia el occidente del país"
      },
      {
        "estado": "En Sucursal Destino",
        "fecha": ISODate("2026-09-04T08:30:00Z"),
        "ubicacion": "Agencia Guatex Huehuetenango",
        "comentario": "Listo para entrega en camión local"
      }
    ],
    "confirmacion_entrega": {
      "entregado": false,
      "fecha_entrega": null,
      "recibido_por": null,
      "documento_dpi": null,
      "firma_digital_url": null,
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012311"),
    "id_venta_mysql": 11,
    "no_cotizacion": null,
    "no_factura": "FEL-000111",
    "empresa_transporte": "Transporte Propio Giganet",
    "numero_guia": "INT-2026-0070",
    "tipo_envio": "Entrega Directa",
    "costo_envio": 0.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "10",
      "direccion_exacta": "Av. La Reforma 12-01",
      "referencias": "Oficinas SIGSA"
    },
    "destinatario": {
      "nombre_completo": "Sistemas e Innovaciones de Guatemala",
      "contacto_recepcion": "Mario Estrada",
      "telefono": "2334-5678",
      "email_notificacion": "compras@sigsa.com.gt"
    },
    "estado_actual": "En Ruta de Entrega",
    "dimensiones_paquete": {
      "peso_kg": 10.5,
      "bultos": 2
    },
    "historial_rastreo": [
      {
        "estado": "Preparado en Bodega",
        "fecha": ISODate("2026-09-05T15:00:00Z"),
        "ubicacion": "Bodega Central Giganet",
        "comentario": "Salida de inventario registrada"
      },
      {
        "estado": "En Ruta de Entrega",
        "fecha": ISODate("2026-09-05T16:00:00Z"),
        "ubicacion": "En camino a Zona 10",
        "comentario": "Unidad móvil #1"
      }
    ],
    "confirmacion_entrega": {
      "entregado": false,
      "fecha_entrega": null,
      "recibido_por": null,
      "documento_dpi": null,
      "firma_digital_url": null,
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012312"),
    "id_venta_mysql": 12,
    "no_cotizacion": null,
    "no_factura": "FEL-000112",
    "empresa_transporte": "Cargo Expreso",
    "numero_guia": "CX-2026-9811",
    "tipo_envio": "Entrega Estándar",
    "costo_envio": 35.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "4",
      "direccion_exacta": "Via 4 1-00, Tecpan Guatemala",
      "referencias": "Oficinas Texnology"
    },
    "destinatario": {
      "nombre_completo": "Texnology ERP Solutions",
      "contacto_recepcion": "Sofia Morales",
      "telefono": "2311-4040",
      "email_notificacion": "fmorales@texnology.com.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 18.0,
      "bultos": 1
    },
    "historial_rastreo": [
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-09-07T10:20:00Z"),
        "ubicacion": "Tecpan Z4",
        "comentario": "Entregado a Sofia Morales"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-09-07T10:20:00Z"),
      "recibido_por": "Sofia Morales",
      "documento_dpi": "2450 11223 0101",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/CX-2026-9811_firma.png",
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012313"),
    "id_venta_mysql": 13,
    "no_cotizacion": "COT-20260907-115000",
    "no_factura": "FEL-000113",
    "empresa_transporte": "Guatex",
    "numero_guia": "GTX-998811",
    "tipo_envio": "Envío Estándar",
    "costo_envio": 40.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "9",
      "direccion_exacta": "12 Calle 2-04, Edificio El Dorado",
      "referencias": "Oficina 502"
    },
    "destinatario": {
      "nombre_completo": "Servicios Informáticos Avanzados",
      "contacto_recepcion": "Ing. Luis Girón",
      "telefono": "2366-1010",
      "email_notificacion": "contacto@sia.com.gt"
    },
    "estado_actual": "En Preparación",
    "dimensiones_paquete": {
      "peso_kg": 5.0,
      "bultos": 1
    },
    "historial_rastreo": [
      {
        "estado": "En Preparación",
        "fecha": ISODate("2026-09-07T13:00:00Z"),
        "ubicacion": "Bodega Central Giganet",
        "comentario": "Orden recibida para embalaje"
      }
    ],
    "confirmacion_entrega": {
      "entregado": false,
      "fecha_entrega": null,
      "recibido_por": null,
      "documento_dpi": null,
      "firma_digital_url": null,
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012314"),
    "id_venta_mysql": 14,
    "no_cotizacion": null,
    "no_factura": "FEL-000114",
    "empresa_transporte": "Cargo Expreso",
    "numero_guia": "CX-2026-9990",
    "tipo_envio": "Entrega a Domicilio",
    "costo_envio": 45.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "10",
      "direccion_exacta": "18 Calle 5-45, Pradera Concejo",
      "referencias": "Torre B"
    },
    "destinatario": {
      "nombre_completo": "Redes y Ciberseguridad Integral",
      "contacto_recepcion": "Andrea Paiz",
      "telefono": "2410-9900",
      "email_notificacion": "info@redsecur.gt"
    },
    "estado_actual": "Entregado",
    "dimensiones_paquete": {
      "peso_kg": 14.0,
      "bultos": 1
    },
    "historial_rastreo": [
      {
        "estado": "Entregado",
        "fecha": ISODate("2026-09-09T14:30:00Z"),
        "ubicacion": "Pradera Concejo Z10",
        "comentario": "Recibido en garita de recepción"
      }
    ],
    "confirmacion_entrega": {
      "entregado": true,
      "fecha_entrega": ISODate("2026-09-09T14:30:00Z"),
      "recibido_por": "Andrea Paiz",
      "documento_dpi": "1650 44332 0101",
      "firma_digital_url": "https://storage.giganet.com.gt/firmas/guias/CX-2026-9990_firma.png",
      "foto_evidencia_url": null
    }
  },
  {
    "_id": ObjectId("665123456789abcdef012315"),
    "id_venta_mysql": 15,
    "no_cotizacion": null,
    "no_factura": "FEL-000115",
    "empresa_transporte": "Transporte Propio Giganet",
    "numero_guia": "INT-2026-0081",
    "tipo_envio": "Entrega Prioritaria",
    "costo_envio": 0.00,
    "direccion_destino": {
      "departamento": "Guatemala",
      "municipio": "Guatemala",
      "zona": "10",
      "direccion_exacta": "Diagonal 6 10-50, Las Margaritas",
      "referencias": "Torre II"
    },
    "destinatario": {
      "nombre_completo": "Soluciones Tecnológicas Integradas",
      "contacto_recepcion": "Fernando Morales",
      "telefono": "2380-1122",
      "email_notificacion": "ventas@soltecin.com.gt"
    },
    "estado_actual": "En Preparación",
    "dimensiones_paquete": {
      "peso_kg": 11.2,
      "bultos": 2
    },
    "historial_rastreo": [
      {
        "estado": "En Preparación",
        "fecha": ISODate("2026-09-10T11:30:00Z"),
        "ubicacion": "Bodega Central Giganet",
        "comentario": "Preparando paquete para envío de la tarde"
      }
    ],
    "confirmacion_entrega": {
      "entregado": false,
      "fecha_entrega": null,
      "recibido_por": null,
      "documento_dpi": null,
      "firma_digital_url": null,
      "foto_evidencia_url": null
    }
  }
]);

// Crear índices estratégicos para optimizar búsquedas frecuentes
db.envios.createIndex({ "id_venta_mysql": 1 });
db.envios.createIndex({ "numero_guia": 1 }, { unique: true });
db.envios.createIndex({ "estado_actual": 1 });
db.envios.createIndex({ "destinatario.nombre_completo": "text" });

print("Inserción de 15 documentos en la colección 'envios' completada con éxito.");
