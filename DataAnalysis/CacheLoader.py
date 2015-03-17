from BinaryMap import BinaryMap
from HeatMap import HeatMap
from sets import Set

class CacheLoader:

    def __init__(self, imageNumber):
        content = []
        with open("Cache" + str(imageNumber) + ".txt") as f:
            content = f.readlines()

        self.binaryMaps = []
        lineNumber = 0
        numAnnotations = int(content[lineNumber])
        lineNumber += 1
        for i in range(numAnnotations):
            numPoints = int(content[lineNumber])
            lineNumber += 1
            coords = []
            for k in range(numPoints):
                coord = [int(n) for n in content[lineNumber].split()]
                lineNumber += 1
                coords.append(coord)
            self.binaryMaps.append(coords)


    

if __name__ == '__main__':
    imageNumber = 1
    c = CacheLoader(imageNumber)
    print c.binaryMaps
    print len(c.binaryMaps)

