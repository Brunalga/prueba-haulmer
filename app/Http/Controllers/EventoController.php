<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    private $eventos = [ //Esto hace un ejemplo de base de datos para poder ejecutar la funcion
        [
            'id_evento' => 1,
            'nombre_evento' => 'Concierto Juan Perez',
            'fecha_evento' => '2023-08-15',
            'horario_evento' => '22:00:00',
            'lugar' => 'Techado de Coquimbo',
            'ciudad' => 'Coquimbo',
            'descripcion' => 'Concierto en vivo del reconocido cantante urbano Juan Perez.',
            'cantidad_max_personas_evento' => 400,
            'precio'=>20000,
            'created_at' => '2023-07-14 21:05:25',
            'updated_at' => '2023-07-14 21:05:25',
            'deleted_at' => null
        ],
        [
            'id_evento' => 2,
            'nombre_evento' => 'Chile v/s Argentina',
            'fecha_evento' => '2023-09-01',
            'horario_evento' => '15:30:00',
            'lugar' => 'Estadio Francisco Sanchez Rumoroso',
            'ciudad' => 'Coquimbo',
            'descripcion' => 'Evento futbolistico donde se enfrentaran 2 equipo de las selecciones femeninas.',
            'cantidad_max_personas_evento' => 10000,
            'precio'=>5000,
            'created_at' => '2023-07-14 21:05:25',
            'updated_at' => '2023-07-14 21:05:25',
            'deleted_at' => null
        ],
        [
            'id_evento' => 3,
            'nombre_evento' => 'Pampilla 2023',
            'fecha_evento' => '2023-09-18',
            'horario_evento' => '15:30:00',
            'lugar' => 'Pampilla de Coquimbo',
            'ciudad' => 'Coquimbo',
            'descripcion' => 'Evento nacional mas grande del pais en donde se entregara una parrila de artistas que haran su show, ademas de disfrutar del ambiente nacional con comidas y bebidas. Se finalizará el evento con fuegos artificiales para celebrar las Fiestas Patrias de Chile(Esto no es seguro ya que las leyes de pirotecnica pueden cambiar)',
            'cantidad_max_personas_evento' => 10000,
            'precio'=>3000,
            'created_at' => '2023-07-14 21:05:25',
            'updated_at' => '2023-07-14 21:05:25',
            'deleted_at' => null
        ],
    ];

    public function infoEventoRelevante(){
        $lista_info_relevante = []; //GENERAR UN ARRAY DE LA INFORMACION ESPERADA
        foreach ($this->eventos as $evento) { //RETORNO DE TODOS LOS EVENTOS EN LA BASE DE DATOS(ARRAY)
            $lista_info_relevante[] = [ //OBTENER SOLO LA INFORMACION RELEVANTE
                'id_evento' => $evento['id_evento'],
                'nombre_evento' => $evento['nombre_evento'],
                'fecha_evento' => $evento['fecha_evento'],
                'horario_evento' => $evento['horario_evento'],
                'lugar' => $evento['lugar'],
                'ciudad' => $evento['ciudad'],
            ];
        }

        return response()->json($lista_info_relevante);
    }
    
    public function infoEventoCompleta(){
        return response()->json($this->eventos);
    }

    public function infoEventoEspecificoCompleta($id){
        $evento = $this->eventos[$id - 1] ?? null;
        if ($evento) {
            return response()->json($evento);
        } else {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }
    }

    public function crearCompra(Request $request){
        // Obtener los datos del formulario
        $idEvento = $request->input('id_evento');

        $cliente = $request->input('cliente');
        $cantidadTickets = $request->input('cantidad_tickets');

        $evento = $this->eventos[$idEvento - 1] ?? null; //VALIDAR QUE EL EVENTO EXISTA EN LA BASE DE DATOS(ARRAY)
        if (!$evento) {
            return response()->json(['message' => 'Evento no encontrado en sistema.'], 404);
        }
        
        date_default_timezone_set('America/Santiago'); //HORARIO EN CHILE

        $compra = [ //ESTO SERIA LA INSERCION A LA BASE DE DATOS DE LA INFORMACION NECESARIA PARA REALIZAR LA COMPRA
            'id_compra' => 1,
            'id_evento' => $idEvento,
            'cliente' => $cliente,
            'cantidad_tickets' => $cantidadTickets,
            'precio_pagar' => $cantidadTickets*$this->eventos[$idEvento - 1]['precio'],
            'fecha_compra' => date('Y-m-d H:i:s'),
        ];

        $this->compras[] = $compra;

        return response()->json([
            'message' => 'Compra creada exitosamente.',
            'compra' => $compra,
        ], 201);
    }

    private $compras = [ //SIMULACION DE BASE DE DATOS CON INFORMACION GUARDADA
        [
            'id_compra' => 1,
            'id_evento' => 1,
            'cliente' => '19452339-4',
            'cantidad_tickets' => 2,
            'precio_pagar' => 40000,
            'fecha_compra' => '2023-07-15',
        ],
        [
            'id_compra' => 2,
            'id_evento' => 3,
            'cliente' => '19452339-4',
            'cantidad_tickets' => 4,
            'precio_pagar' => 12000,
            'fecha_compra' => '2023-07-16',
        ],
        [
            'id_compra' => 3,
            'id_evento' => 2,
            'cliente' => '19452339-4',
            'cantidad_tickets' => 6,
            'precio_pagar' => 18000,
            'fecha_compra' => '2023-07-17',
        ],
        [
            'id_compra' => 4,
            'id_evento' => 2,
            'cliente' => '12570674-6',
            'cantidad_tickets' => 6,
            'precio_pagar' => 30000,
            'fecha_compra' => '2023-07-18',
        ],
        [
            'id_compra' => 5,
            'id_evento' => 2,
            'cliente' => '13359052-8',
            'cantidad_tickets' => 20,
            'precio_pagar' => 100000,
            'fecha_compra' => '2023-07-19',
        ],
    ];

    public function listarComprasCliente($rut_cliente){
        $comprasCliente = array_filter($this->compras, function ($compra) use ($rut_cliente) {
            return $compra['cliente'] == $rut_cliente;
        });
    
        if (empty($comprasCliente)) {
            return response()->json(['message' => 'No se encontraron compras para el cliente ingresado.'], 404);
        }
    
        return response()->json($comprasCliente);
    }
}


