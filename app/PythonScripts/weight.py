# import serial
# import serial.tools.list_ports
# import sys
import random


def w2():
    
    list1 = [1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000]
    print(random.choice(list1))

    # try:
    #     serialBout = serial.Serial()
    #     serialBout.port = "COM5"
    #     serialBout.baudrate = 9600
    #     serialBout.open()

    #     packet = serialBout.readline()
    #     wtt = packet.decode("utf").rstrip("\n")
    #     print(wtt)
    # except:
    #     print("error")


    # while True:
    #     if serialBout.in_waiting:
    #         packet = serialBout.readline()
    #         wtt = packet.decode("utf").rstrip("\n")
    #         print(wtt)



w2()
