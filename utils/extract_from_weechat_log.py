#!/usr/bin/env python3

# Generate the servers log from a weechat IRC log
# Each log entry is a message on the channel with the following format:
# [component] entry
#
# To get these, you can use the following command:
#
# `egrep "\[.*\] .*" log` > candidates
#
# Then, you can clean a little bit your candidates entries file.
#
# Once done, you can use this script to dump a JSON log:
#
# ./extract_from_weechat_log.py candidates

import json
import os
import re
import sys


SOURCE = "freenode #nasqueron-ops"


def get_component(text):
    matches = re.match("\[(.*)\] (.*)", text)
    return matches[1]


def get_entry(text):
    matches = re.match("\[(.*)\] (.*)", text)
    return matches[2]


def get_log_entry_from_line(raw_line):
    line = raw_line.strip().split('\t')
    return {
        "date": line[0].replace(' ', 'T') + "+0000",
        "emitter": line[1],
        "source": SOURCE,
        "component": get_component(line[2]),
        "entry": get_entry(line[2])
    }


def extract_log(filename):
    return [get_log_entry_from_line(line) for line in open(filename)]


def run():
    argc = len(sys.argv)

    if argc < 2:
        print("Usage: {} <log to extract>".format(sys.argv[0]))
        sys.exit(64)

    filename = sys.argv[1]
    if not os.path.isfile(filename):
        print("File not found: " + filename)
        sys.exit(2)

    log = extract_log(filename)
    print(json.dumps(log))


if __name__ == "__main__":
    run()
