from PolygonAnnotation import PolygonAnnotation
from sets import Set
#import numpy as np

class BinaryMap:

    def __init__(self, imageName):
        polygon = PolygonAnnotation(imageName)
        self.junk = polygon.junk
        if self.junk == False:
            self.create_binary_map(polygon)

    def create_binary_map(self,polygon):
        self.interiorPoints = []
        for i in range(0,900,1):
            for j in range(0, 900, 1):
                if self.point_inside_polygon(i,j,polygon.allPoints):
                    self.interiorPoints.append((i,j))

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

if __name__ == '__main__':
    b = BinaryMap('../results/BlurredContours/Image0-10d2423eac08988b513ebbff7b6cd207.json')
