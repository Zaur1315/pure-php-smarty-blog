<?php
declare(strict_types=1);

namespace App\Core\View;

use Smarty\Exception;
use Smarty\Smarty;

final class View
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();

        $this->smarty->setTemplateDir(__DIR__ . '/../../../templates');
        $this->smarty->setCompileDir(__DIR__ . '/../../../storage/smarty/compile');
        $this->smarty->setCacheDir(__DIR__ . '/../../../storage/smarty/cache');
        $this->smarty->setConfigDir(__DIR__ . '/../../../storage/smarty/config');
    }

    /**
     * @throws Exception
     */
    public function render(string $template, array $params = []): string
    {
        foreach ($params as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        return $this->smarty->fetch($template);
    }
}