<?php

class ircMsg
{
    private $raw;
    private $nick;
    private $name;
    private $host;
    private $server;
    private $command;
    private $parameters = array();
    
    public function __construct($message)
    {
        $this->parse($message);
    }
    
    public function getRaw()
    {
        return $this->raw;
    }
    
    public function getNick()
    {
        return $this->nick;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getHost()
    {
        return $this->host;
    }
    
    public function getServer()
    {
        return $this->server;
    }
    
    public function getCommand()
    {
        return $this->command;
    }
    
    public function getParameters()
    {
        return $this->parameters;
    }
    
    private function parse($message)
    {
        $this->raw = $message;
        
        list($lval, $message) = explode(' ', $message, 2);
        if ($lval[0] =  ':')
        {
            $lval = explode('!', $lval, 2);
            
            if (count($lval) === 1)
            {
                $this->message = substr($lval, 1);
            }
            else
            {
                list($this->nick, $sub) = $lval;
                $this->nick = substr($this->nick, 1);
                list($this->name, $this->host) = explode('@', $sub, 2);
            }
            
            list($lval, $message) = explode(' ', $message, 2);
        }
        
        $this->command = $lval;
        
        $lval = explode(' ', $message);
        foreach ($lval as $key => $value)
        {
            if ($value[0] == ':')
            {
                $lval[$key] = substr($value, 1);
                $lval = array_merge(
                    array_slice($lval, 0, $key),
                    array(implode(' ', array_slice($lval, $key)))
                );
                $this->parameters = $lval;
                
                return;
            }
        }
        $this->parameters = $lval;
    }
}
