#!/bin/sh
mkdir -p ~/carland_backups
tar -jcf ~/carland_backups/carland_`date +%F_%H-%M-%S`.tar.bz2 .
