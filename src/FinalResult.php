<?php

/**
 * Note;
 * Assuming that this file is part of a large application, 
 * then there must be some other processors that are handling those file-reading and file-parsing. 
 * Therefore, I think all the "fopen" and the code that read a specific format that only applied
 * for Singapore Bank should definitely not be here.
 *
 * As well, as for the code-challenge purpose, 
 * there is no clear requirement of what is the prior procedure before it reaches to this class,
 * or who (or what script) will be executing this class, hence, the code challenge is in my opinion, a guessing game.
 * 
 * Therefore, I am going to assume some scenario of use-case and implement this application in that direction.
 * With a note that, the possibility of refactoring this set of code is, infinite (metaphor).
 */

class FinalResult
{
    function result(DocumentParser $parser) : array
    {
        return $parser->data()->output();
    }
}

?>
