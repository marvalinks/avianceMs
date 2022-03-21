import serial
import serial.tools.list_ports
import sys


# def readWeight(port_number):

#     ports = serial.tools.list_ports.comports()
#     port_value = ""
#     port_list = []

#     if(len(port_list) < 1):
#         return

#     for sel_port in ports:
#         port_list.append(str(sel_port))

#     for x in range(0, len(port_list)):
#         if port_list[x].startswith(port_number):
#             port_value = port_number

#     if self.port_value and self.port_value.strip():
#         pass
#     else:
#         self.onPopPress("Port Selected not available!")
#         return

#     serialBout = serial.Serial()
#     serialBout.port = port_number
#     serialBout.open()

#     packet = serialBout.readline()
#     self.ids.weight.text = packet.decode("utf").rstrip("\n")


class WeightScale:

    # init method or constructor
    def __init__(self, port_number):
        self.port_number = port_number

    # Sample Method
    def read_weight(self):
        port_number = self.port_number
        ports = serial.tools.list_ports.comports()
        self.port_value = ""
        port_list = []

        for sel_port in ports:
            port_list.append(str(sel_port))

        if(len(port_list) < 1):
            print('No ports opened or available!')
            return

        # print(port_list)

        for x in range(0, len(port_list)):
            if port_list[x].startswith(port_number):
                self.port_value = port_number

        if self.port_value and self.port_value.strip():
            pass
        else:
            print('Port Selected not available!')
            return

        serialBout = serial.Serial()
        serialBout.port = port_number
        serialBout.open()

        packet = serialBout.readline()
        self.ids.weight.text = packet.decode("utf").rstrip("\n")


ws = WeightScale(sys.argv[1])
ws.read_weight()

# def read_weight():
#     # print('Hello, my name is', self.port_number)
#     print('hello')


# read_weight()
