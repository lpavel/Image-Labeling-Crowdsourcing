from BinaryMap import BinaryMap
from HeatMap import HeatMap
from sets import Set

imageNumber = 0

def printBinaryMaps(binaryMaps):
    print(len(binaryMaps))
    for binaryMap in binaryMaps:
        print(len(binaryMap.interiorPoints))
        for x,y in binaryMap.interiorPoints:
            print( str(x) + " " + str(y))

if __name__ == '__main__':
    numImages = []
    polygons = []
    content = []
    with open("resultsBlurred.txt") as f:
        content = f.readlines()

    binaryMaps = []

    for line in content:
        if line.startswith("Image" +
                           str(imageNumber) + "-") is True:
            binaryMap = BinaryMap("../results/BlurredContours/" +
                                  line.strip('\n'))
            if binaryMap.junk == False:
                binaryMaps.append(binaryMap)
    
    printBinaryMaps(binaryMaps)