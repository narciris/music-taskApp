<?php

namespace App\Enums;

enum TaskCategory : string
{
  case TECHNIQUE = 'Technique';
  case RECORDING = 'Recording';
  case COMPOSITION  = 'Composition';
  case TRAINING  = 'Training';
  case THEORY =  'theory';
  case REPERTOIRE  = 'repertoire';
}
