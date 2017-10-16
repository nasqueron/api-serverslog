<?php

/*
 ______                                                  _______ _______ ___
|   _  \.---.-.-----.-----.--.--.-----.----.-----.-----.|   _   |   _   |   |
|.  |   |  _  |__ --|  _  |  |  |  -__|   _|  _  |     ||.  1   |.  1   |.  |
|.  |   |___._|_____|__   |_____|_____|__| |_____|__|__||.  _   |.  ____|.  |
|:  |   |              |__|                             |:  |   |:  |   |:  |
|::.|   |  Servers log :: Add new entries               |::.|:. |::.|   |::.|
`--- ---'  https://api.nasqueron.org/serverslog         `--- ---`---'   `---'

                                                                              */

use Nasqueron\Api\ServersLog\Service;

require __DIR__ . '/../../vendor/autoload.php';

$service = new Service();
$service->handle();
