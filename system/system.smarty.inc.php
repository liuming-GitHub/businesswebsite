<?php
    require("./smarty/Smarty.class.php");                     // 调用smarty配置类文件
    class SmartyProject extends Smarty{                     // 定义类，继承smarty父类
        function SmartyProject(){                           // 定义方法，配置smarty模板
            $this->template_dir = "./";                     // 指定模板文件存储在根目录下
            $this->compile_dir = "./system/templates_c";    // 指定编译文件存储位置
            $this->config_dir = "./system/configs/";        // 指定配置文件存储位置
            $this->cache_dir = "./system/cache/";           // 指定缓存文件存储位置
        }  
    }
?>
