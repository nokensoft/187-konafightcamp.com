import './bootstrap';

import Alpine from 'alpinejs';
import posApp from './posApp';

window.Alpine = Alpine;

Alpine.data('posApp', posApp);

Alpine.start();
