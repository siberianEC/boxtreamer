#!/bin/bash -l
#$ -S /bin/bash
#$ -N $2
amixer set PCM $1%
