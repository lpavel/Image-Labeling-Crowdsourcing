from BinaryMap import BinaryMap
from sets import Set
import ast
labeledImages = 1;

class HeatMap:

    def __init__(self, binaryMaps):
        self.heatMap = [ [0]*900 ] *900

        for binaryMap in binaryMaps:
            for x,y in binaryMap:
                self.heatMap[x][y] = selfheatMap[x][y] + 1


    def getHeat(self, polygon):
        ''' do the intelligence here '''
                    
        
