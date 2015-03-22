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

    def createBinaryFromHeat():
        binaryMapPoints = []
        for x,y in self.nonZeroSet:
            if self.heatMap[x][y] < int(self.totalMaps/3):
                binaryMapPoints.append((x,y))

        self.binaryMap = BinaryMap(None, binaryMapPoints)
