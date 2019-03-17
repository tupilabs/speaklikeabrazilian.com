#!/bin/bash

python database2ontology.py && \
    rsync -rtvu --delete dist/_expressions/ ../_expressions/ && \
    rsync -rtvu --delete dist/expressions/ ../expressions/
