from BinaryMap import BinaryMap
from sets import Set
import ast
labeledImages = 1;

class HeatMap:

    def __init__(self, binaryMaps):
        self.heatMap = [ [0]*900 ] *900
        self.totalMaps = len(binaryMaps)
        self.nonZeroSet = Set()
        
        # create the heatmap by adding all binary maps together 
        for binaryMap in binaryMaps:
            for x,y in binaryMap:
                if (x,y) not in nonZeroSet:
                    nonZeroSet.add((x,y))
                self.heatMap[x][y] = selfheatMap[x][y] + 1
        createBinaryFromHeat()

    def createBinaryFromHeat():
        self.binaryMap = [ [0]*900 ] *900
        for x,y in self.nonZeroSet:
            if self.heatMap[x][y] < int(self.totalMaps/3):
                self.binaryMap[x][y] = 1
                        
