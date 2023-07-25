<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{

    private $eventos = [
        //Esto hace un ejemplo de base de datos para poder ejecutar la funcion
        [
            'id_evento' => 1,
            'nombre_evento' => 'Concierto Juan Perez',
            'fecha_evento' => '2023-08-15',
            'horario_evento' => '22:00:00',
            'lugar' => 'Techado de Coquimbo',
            'ciudad' => 'Coquimbo',
            'descripcion' => 'Concierto en vivo del reconocido cantante urbano Juan Perez.',
            'cantidad_max_personas_evento' => 400,
            'precio' => 20000,
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
            'precio' => 5000,
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
            'precio' => 3000,
            'created_at' => '2023-07-14 21:05:25',
            'updated_at' => '2023-07-14 21:05:25',
            'deleted_at' => null
        ],
    ];

    private $compras = [
        //SIMULACION DE BASE DE DATOS CON INFORMACION GUARDADA
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

    // Define the constructor
    public function __construct()
    {
        date_default_timezone_set('America/Santiago');
    }

    public function infoEventoRelevante()
    {
        $lista_info_relevante = []; //GENERAR UN ARRAY DE LA INFORMACION ESPERADA
        foreach ($this->eventos as $evento) { //RETORNO DE TODOS LOS EVENTOS EN LA BASE DE DATOS(ARRAY)
            $lista_info_relevante[] = [
                //OBTENER SOLO LA INFORMACION RELEVANTE
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

    public function infoEventoCompleta()
    {
        try {
            return response()->json($this->eventos);
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving event information.', 500);
        }
    }

    public function infoEventoEspecificoCompleta($id)
    {
        try {
            $evento = $this->findEventoById($id);

            if (!$evento) {
                throw new \Exception('Evento no encontrado en sistema.', 404);
            }

            return response()->json($evento);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    private function findEventoById($id)
    {
        return $this->eventos[$id - 1] ?? null;
    }

    public function crearCompra(Request $request)
    {
        try {
            // Obtener los datos del formulario
            $request->validate([
                'id_evento' => 'required|integer|exists:eventos,id_evento',
                // Valida que el ID del evento exista en la tabla eventos
                'cliente' => 'required|string',
                'cantidad_tickets' => 'required|integer|min:1',
            ]);

            $idEvento = $request->input('id_evento');
            $cliente = $request->input('cliente');
            $cantidadTickets = $request->input('cantidad_tickets');

            $evento = $this->eventos[$idEvento - 1] ?? null; //VALIDAR QUE EL EVENTO EXISTA EN LA BASE DE DATOS(ARRAY)
            if (!$evento) {
                return $this->errorResponse('Evento no encontrado en sistema.', 404);
            }

            $compra = [
                //ESTO SERIA LA INSERCION A LA BASE DE DATOS DE LA INFORMACION NECESARIA PARA REALIZAR LA COMPRA
                'id_compra' => 1,
                'id_evento' => $idEvento,
                'cliente' => $cliente,
                'cantidad_tickets' => $cantidadTickets,
                'precio_pagar' => $cantidadTickets * $this->eventos[$idEvento - 1]['precio'],
                'fecha_compra' => date('Y-m-d H:i:s'),
            ];

            $this->compras[] = $compra;

            return response()->json([
                'message' => 'Compra creada exitosamente.',
                'compra' => $compra,
            ], 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating purchase.', 500);
        }
    }

    public function listarComprasCliente($rut_cliente)
    {
        try {
            $comprasCliente = array_filter($this->compras, function ($compra) use ($rut_cliente) {
                return $compra['cliente'] == $rut_cliente;
            });

            if (empty($comprasCliente)) {
                return $this->errorResponse('No se encontraron compras para el cliente ingresado.', 404);
            }

            return response()->json($comprasCliente);
        } catch (\Exception $e) {
            return $this->errorResponse('Error retrieving client purchases.', 500);
        }
    }

    protected function errorResponse($message, $statusCode)
    {
        return response()->json(['message' => $message], $statusCode);
    }
}