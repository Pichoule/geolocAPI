<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerCX1wQ8p\srcDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerCX1wQ8p/srcDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerCX1wQ8p.legacy');

    return;
}

if (!\class_exists(srcDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerCX1wQ8p\srcDevDebugProjectContainer::class, srcDevDebugProjectContainer::class, false);
}

return new \ContainerCX1wQ8p\srcDevDebugProjectContainer(array(
    'container.build_hash' => 'CX1wQ8p',
    'container.build_id' => '9e32b633',
    'container.build_time' => 1540974166,
), __DIR__.\DIRECTORY_SEPARATOR.'ContainerCX1wQ8p');
