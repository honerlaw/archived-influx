<?php

namespace Server\Net;

/**
 * Forces all responses to have a build method so the response
 * can be written to the socket
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
interface Response {

    public function build(): string;

}
