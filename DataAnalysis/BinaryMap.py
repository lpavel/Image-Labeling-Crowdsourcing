from PolygonAnnotation import PolygonAnnotation
from sets import Set
#import numpy as np

class BinaryMap:
    '''
    When isCache is False, it does regular read form results Json
    When isCache is True, reads the results obtained running create_binary_map
    before. Since create_binary_map takes a very long time, it has been tried to
    optimized by running it once and saved the results.
    '''
    def __init__(self, fileName, points = None):

        if points == None:
            polygon = PolygonAnnotation(fileName)
            self.junk = polygon.junk
            if self.junk == False:
                self.create_binary_map(polygon)
        else:
            self.junk = False
            self.interiorPoints = Set()
            for point in points:
                self.interiorPoints.add(point)                

                
    '''
    The very expensive operation that finds out which points are insinde the
    polygon created by the crowd. Goes through all points and stores only the
    ones that are inside.
    '''
    def create_binary_map(self,polygon):
        self.interiorPoints = Set()
        for i in range(0, 900, 1):
            for j in range(0, 900, 1):
                for pointsInContour in polygon.points:
                    if (i,j) not in self.interiorPoints: 
                        if self.point_inside_polygon(i, j, pointsInContour):
                            self.interiorPoints.add((i, j))


    '''    
    Next function is taken from the web:
    http://www.ariel.com.au/a/python-point-int-poly.html
    '''
    def point_inside_polygon(self,x,y,poly):
        n = len(poly)
        inside =False

        p1x,p1y = poly[0]
        for i in range(n+1):
            p2x,p2y = poly[i % n]
            if y > min(p1y,p2y):
                if y <= max(p1y,p2y):
                    if x <= max(p1x,p2x):
                        if p1y != p2y:
                            xinters = (y-p1y)*(p2x-p1x)/(p2y-p1y)+p1x
                        if p1x == p2x or x <= xinters:
                            inside = not inside
            p1x,p1y = p2x,p2y
        
        return inside



    def compareBinaryMaps(self, otherBinaryMap):
        commonPoints = 0
#        print(self.interiorPoints)
        for point in self.interiorPoints:
            if point in otherBinaryMap.interiorPoints:
                commonPoints += 1
    
        differentPoints = len(self.interiorPoints) + len(otherBinaryMap.interiorPoints) - (2* commonPoints)
        totalPoints = len(self.interiorPoints) + len(otherBinaryMap.interiorPoints)
        return 1 - (float(differentPoints) / (totalPoints))
                
    
if __name__ == '__main__':
    b = BinaryMap('../results/BlurredContours/Image0-10d2423eac08988b513ebbff7b6cd207.json')
    print (b.interiorPoints)
    print (len(b.interiorPoints))
