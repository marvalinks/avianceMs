import serial
import serial.tools.list_ports
import sys


def w2():
    serialBout = serial.Serial()
    serialBout.port = "COM5"
    serialBout.open()

    packet = serialBout.readline()
    wtt = packet.decode("utf").rstrip("\n")
    print(wtt)


w2()
