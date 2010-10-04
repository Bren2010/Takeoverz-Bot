<?php

class modules
{
    private $modules = array();
    
    public function __construct()
    {
        $this->load();
    }
    
    public function load()
    {
        $parents = scandir('modules');
        array_shift($parents);
        array_shift($parents);
        foreach ($parents as $parent)
        {
            $children = scandir('modules/' . $parent);
            array_shift($children);
            array_shift($children);
            foreach ($children as $child)
            {
                $contents = file_get_contents("modules/{$parent}/{$child}");
                $module = eval($contents);
                list($childName) = explode('.', $child);
                $this->modules[$parent][$childName] = array(
                    'module' => $module,
                    'enabled' => true
                );
            }
        }
    }
    
    public function unload()
    {
        $this->modules = array();
    }
    
    public function reload()
    {
        $this->unload();
        $this->load();
    }
    
    public function disable($command, $module)
    {
        if (!$this->modules[$command][$module]) return;
        
        $this->modules[$command][$module]['enabled'] = true;
    }
    
    public function enable($command, $module)
    {
        if (!$this->modules[$command][$module]) return;
        
        $this->modules[$command][$module]['enabled'] = true;
    }
    
    public function toggle($command, $module)
    {
        if (!$this->modules[$command][$module]) return;
        
        $val = $this->modules[$command][$module]['enabled'];
        $this->modules[$command][$module]['enabled'] = !$val;
    }
    
    public function hook($hook, $message)
    {
        if (!$this->modules[$hook]) return;
        
        foreach ($this->modules[$hook] as $module)
        {
            if (!$module['enabled']) continue;
            $module['module']($message);
        }
    }
}
