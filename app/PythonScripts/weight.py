import serial
import serial.tools.list_ports
import sys
import random


def w2():
    # list1 = [1, 2, 3, 4, 5, 6, 7, 8, 9]
    # print(random.choice(list1))

    serialBout = serial.Serial()
    serialBout.port = "COM5"
    serialBout.open()

    packet = serialBout.readline()
    wtt = packet.decode("utf").rstrip("\n")
    print(wtt)


w2()
