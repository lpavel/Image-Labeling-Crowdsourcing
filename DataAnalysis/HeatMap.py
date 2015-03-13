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
                    
        


if __name__ == '__main__':
    numImages = []
    polygons = []
    content = []
    with open("resultsBlurred.txt") as f:
        content = f.readlines()

    binaryMaps = []
    #first need to cache all Binary Maps
    for imageNumber in range(9, 11):
        # very inefficient because the file gets read too many times
        binaryMapsImage = []
        for line in content:
            if line.startswith("Image" +
                               str(imageNumber) + "-") is True:
                binaryMap = BinaryMap("../results/BlurredContours/" +
                                            line.strip('\n'))
                if binaryMap.junk == False:
                    binaryMapsImage.append(binaryMap)
        binaryMaps.append(binaryMapsImage)
        pprint(binaryMaps)

    '''
        
    #TODO: need to backtrack recursively for all combinations
    for imageNumber in range(0, 11):
        # very inefficient because the file gets read too many times
        polygonsImage = []
        for line in content:
            if line.startswith("Image" +
                               str(imageNumber) + "-") is True:
                polygon = Polygon("../results/BlurredContours/" + line.strip('\n'))
                if polygon.junk == False:
                    polygonsImage.append(polygon)

        polygons.append(polygonsImage)
    print(polygons)
    #    heat_map.process_images()
    
    '''
