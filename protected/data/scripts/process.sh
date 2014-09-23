#!/bin/bash
export DISPLAY=:1
exec ./photoscan-pro/photoscan.sh &
sleep 1
xdotool mousemove  485 60 click 1
xdotool mousemove  485 85 click 1
