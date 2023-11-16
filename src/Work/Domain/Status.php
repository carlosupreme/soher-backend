<?php

namespace Soher\Work\Domain;
enum Status: string
{
    case OPEN = 'open'; // Justo despues de solicituar un trabajo como cliente
    case PROGRESS = 'progress'; // El trabajor y el cliente llegaron a un acuerdo
    case FINISHED = 'finished'; // El trabajador reportó como finalizada la solicitud
    case CLOSED = 'closed'; // El cliente confirmó que fue finalizada (Fin del cliclo de vida de un trabajo)
    case ARCHIVED = 'archived'; // Eliminada por el cliente
    case BLOCKED = 'blocked'; // El trabajador o el cliente reportaron una queja

}
