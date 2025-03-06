#!/bin/bash

# Iniciar el servidor de desarrollo de Vite en segundo plano
npm run dev &

# Iniciar Apache en primer plano
apache2-foreground