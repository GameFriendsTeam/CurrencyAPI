<?php
$phar = new Phar("build/Currency.phar");
$phar->buildFromDirectory(__DIR__, '/^(?!.*vendor).*$/');
$phar->setStub('<?php __HALT_COMPILER();');