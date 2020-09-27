<?php
/**
 *------------------------------------------------------
 * ApisEvent.php
 *------------------------------------------------------
 *
 * @author    lestat9527@gmail.com
 * @version   V1.0
 *
 */

namespace Lwj\Rbac\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class MenuApiEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
