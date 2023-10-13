<?php

namespace TriasClient\types\FPTF;

enum FPTFMode
{
    case AIRCRAFT;
    case BICYCLE;
    case BUS;
    case CAR;
    case GONDOLA;
    case TAXI;
    case TRAIN;
    case UNKNOWN;
    case WALKING;
    case WATERCRAFT;
}
