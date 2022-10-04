<?php
function getTitle()
{
    Global $pageName;
    if(isset($pageName))
    {
        return $pageName;
    }else
    {
        return "Default";
    }
}
