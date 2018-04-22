<?xml version="1.0" encoding="ISO-8859-1"?>
<StyledLayerDescriptor version="1.0.0"
    xsi:schemaLocation="http://www.opengis.net/sld StyledLayerDescriptor.xsd"
    xmlns="http://www.opengis.net/sld"
    xmlns:ogc="http://www.opengis.net/ogc"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <NamedLayer>
    <Name>Attribute-based polygon</Name>
    <UserStyle>
      <Title>SLD Cook Book: Attribute-based polygon</Title>
      <FeatureTypeStyle>
        <Rule>
          <Name> Menor 2 </Name>
          <Title>Menor 2</Title>
          <ogc:Filter>
            <ogc:PropertyIsLessThan>
              <ogc:PropertyName>contador</ogc:PropertyName>
              <ogc:Literal>2</ogc:Literal>
            </ogc:PropertyIsLessThan>
          </ogc:Filter>
      	  <MaxScaleDenominator>1.0E20</MaxScaleDenominator>
          <PolygonSymbolizer>
            <Fill>
              <CssParameter name="fill">#ffffb2</CssParameter>
              <CssParameter name="fill-opacity">0.6</CssParameter>
            </Fill>
            <Stroke>
           <CssParameter name="stroke">#000000</CssParameter>
           <CssParameter name="stroke-width">2</CssParameter>
         </Stroke>
          </PolygonSymbolizer>
          <TextSymbolizer>
          <Geometry>
             <ogc:Function name="centroid">
                <ogc:PropertyName>the_geom_zonas</ogc:PropertyName>
             </ogc:Function>
          </Geometry>
         <Label>
           <ogc:PropertyName>contador</ogc:PropertyName>
         </Label>
         <Font>
           <CssParameter name="font-family">Arial</CssParameter>
           <CssParameter name="font-size">12</CssParameter>
           <CssParameter name="font-style">normal</CssParameter>
           <CssParameter name="font-weight">bold</CssParameter>
         </Font>
         <LabelPlacement>
           <PointPlacement>
             <Displacement>
               <DisplacementX>0</DisplacementX>
               <DisplacementY>0</DisplacementY>
             </Displacement>
           </PointPlacement>
         </LabelPlacement>
         <Fill>
           <CssParameter name="fill">#000000</CssParameter>
         </Fill>
       </TextSymbolizer>
        </Rule>
        <Rule>
          <Name>2 - 4</Name>
          <Title>2 - 4</Title>
          <ogc:Filter>
            <ogc:And>
              <ogc:PropertyIsGreaterThanOrEqualTo>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>2</ogc:Literal>
              </ogc:PropertyIsGreaterThanOrEqualTo>
              <ogc:PropertyIsLessThan>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>4</ogc:Literal>
              </ogc:PropertyIsLessThan>
            </ogc:And>
          </ogc:Filter>
           <MaxScaleDenominator>1.0E20</MaxScaleDenominator>
          <PolygonSymbolizer>
            <Fill>
              <CssParameter name="fill">#fed976</CssParameter>
              <CssParameter name="fill-opacity">0.6</CssParameter>
            </Fill>
            <Stroke>
           <CssParameter name="stroke">#000000</CssParameter>
           <CssParameter name="stroke-width">2</CssParameter>
         </Stroke>
          </PolygonSymbolizer>
          <TextSymbolizer>
          <Geometry>
             <ogc:Function name="centroid">
                <ogc:PropertyName>the_geom_zonas</ogc:PropertyName>
             </ogc:Function>
          </Geometry>
         <Label>
           <ogc:PropertyName>contador</ogc:PropertyName>
         </Label>
         <Font>
           <CssParameter name="font-family">Arial</CssParameter>
           <CssParameter name="font-size">12</CssParameter>
           <CssParameter name="font-style">normal</CssParameter>
           <CssParameter name="font-weight">bold</CssParameter>
         </Font>
         <LabelPlacement>
           <PointPlacement>
             <Displacement>
               <DisplacementX>0</DisplacementX>
               <DisplacementY>0</DisplacementY>
             </Displacement>
           </PointPlacement>
         </LabelPlacement>
         <Fill>
           <CssParameter name="fill">#000000</CssParameter>
         </Fill>
       </TextSymbolizer>
        </Rule>
        <Rule>
          <Name>4 - 6</Name>
          <Title>4 - 6</Title>
          <ogc:Filter>
            <ogc:And>
              <ogc:PropertyIsGreaterThanOrEqualTo>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>4</ogc:Literal>
              </ogc:PropertyIsGreaterThanOrEqualTo>
              <ogc:PropertyIsLessThan>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>6</ogc:Literal>
              </ogc:PropertyIsLessThan>
            </ogc:And>
          </ogc:Filter>
           <MaxScaleDenominator>1.0E20</MaxScaleDenominator>
          <PolygonSymbolizer>
            <Fill>
              <CssParameter name="fill">#feb24c</CssParameter>
              <CssParameter name="fill-opacity">0.6</CssParameter>
            </Fill>
            <Stroke>
           <CssParameter name="stroke">#000000</CssParameter>
           <CssParameter name="stroke-width">2</CssParameter>
         </Stroke>
          </PolygonSymbolizer>
          <TextSymbolizer>
          <Geometry>
             <ogc:Function name="centroid">
                <ogc:PropertyName>the_geom_zonas</ogc:PropertyName>
             </ogc:Function>
          </Geometry>
         <Label>
           <ogc:PropertyName>contador</ogc:PropertyName>
         </Label>
         <Font>
           <CssParameter name="font-family">Arial</CssParameter>
           <CssParameter name="font-size">12</CssParameter>
           <CssParameter name="font-style">normal</CssParameter>
           <CssParameter name="font-weight">bold</CssParameter>
         </Font>
         <LabelPlacement>
           <PointPlacement>
             <Displacement>
               <DisplacementX>0</DisplacementX>
               <DisplacementY>0</DisplacementY>
             </Displacement>
           </PointPlacement>
         </LabelPlacement>
         <Fill>
           <CssParameter name="fill">#000000</CssParameter>
         </Fill>
       </TextSymbolizer>
        </Rule>
        <Rule>
          <Name>6 - 8</Name>
          <Title>6 - 8</Title>
          <ogc:Filter>
            <ogc:And>
              <ogc:PropertyIsGreaterThanOrEqualTo>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>6</ogc:Literal>
              </ogc:PropertyIsGreaterThanOrEqualTo>
              <ogc:PropertyIsLessThan>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>8</ogc:Literal>
              </ogc:PropertyIsLessThan>
            </ogc:And>
          </ogc:Filter>
           <MaxScaleDenominator>1.0E20</MaxScaleDenominator>
          <PolygonSymbolizer>
            <Fill>
              <CssParameter name="fill">#fd8d3c</CssParameter>
              <CssParameter name="fill-opacity">0.6</CssParameter>
            </Fill>
            <Stroke>
           <CssParameter name="stroke">#000000</CssParameter>
           <CssParameter name="stroke-width">2</CssParameter>
         </Stroke>
          </PolygonSymbolizer>
          <TextSymbolizer>
          <Geometry>
             <ogc:Function name="centroid">
                <ogc:PropertyName>the_geom_zonas</ogc:PropertyName>
             </ogc:Function>
          </Geometry>
         <Label>
           <ogc:PropertyName>contador</ogc:PropertyName>
         </Label>
         <Font>
           <CssParameter name="font-family">Arial</CssParameter>
           <CssParameter name="font-size">12</CssParameter>
           <CssParameter name="font-style">normal</CssParameter>
           <CssParameter name="font-weight">bold</CssParameter>
         </Font>
         <LabelPlacement>
           <PointPlacement>
             <Displacement>
               <DisplacementX>0</DisplacementX>
               <DisplacementY>0</DisplacementY>
             </Displacement>
           </PointPlacement>
         </LabelPlacement>
         <Fill>
           <CssParameter name="fill">#000000</CssParameter>
         </Fill>
       </TextSymbolizer>
        </Rule>
        <Rule>
          <Name>8 - 10</Name>
          <Title>8 - 10</Title>
          <ogc:Filter>
            <ogc:And>
              <ogc:PropertyIsGreaterThanOrEqualTo>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>8</ogc:Literal>
              </ogc:PropertyIsGreaterThanOrEqualTo>
              <ogc:PropertyIsLessThan>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>10</ogc:Literal>
              </ogc:PropertyIsLessThan>
            </ogc:And>
          </ogc:Filter>
           <MaxScaleDenominator>1.0E20</MaxScaleDenominator>
          <PolygonSymbolizer>
            <Fill>
              <CssParameter name="fill">#fc4e2a</CssParameter>
              <CssParameter name="fill-opacity">0.6</CssParameter>
            </Fill>
            <Stroke>
           <CssParameter name="stroke">#000000</CssParameter>
           <CssParameter name="stroke-width">2</CssParameter>
         </Stroke>
          </PolygonSymbolizer>
          <TextSymbolizer>
          <Geometry>
             <ogc:Function name="centroid">
                <ogc:PropertyName>the_geom_zonas</ogc:PropertyName>
             </ogc:Function>
          </Geometry>
         <Label>
           <ogc:PropertyName>contador</ogc:PropertyName>
         </Label>
         <Font>
           <CssParameter name="font-family">Arial</CssParameter>
           <CssParameter name="font-size">12</CssParameter>
           <CssParameter name="font-style">normal</CssParameter>
           <CssParameter name="font-weight">bold</CssParameter>
         </Font>
         <LabelPlacement>
           <PointPlacement>
             <Displacement>
               <DisplacementX>0</DisplacementX>
               <DisplacementY>0</DisplacementY>
             </Displacement>
           </PointPlacement>
         </LabelPlacement>
         <Fill>
           <CssParameter name="fill">#000000</CssParameter>
         </Fill>
       </TextSymbolizer>
        </Rule>
        <Rule>
          <Name>10 - 15</Name>
          <Title> 10 - 15</Title>
          <ogc:Filter>
            <ogc:And>
              <ogc:PropertyIsGreaterThanOrEqualTo>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>10</ogc:Literal>
              </ogc:PropertyIsGreaterThanOrEqualTo>
              <ogc:PropertyIsLessThan>
                <ogc:PropertyName>contador</ogc:PropertyName>
                <ogc:Literal>15</ogc:Literal>
              </ogc:PropertyIsLessThan>
            </ogc:And>
          </ogc:Filter>
           <MaxScaleDenominator>1.0E20</MaxScaleDenominator>
          <PolygonSymbolizer>
            <Fill>
              <CssParameter name="fill">#e31a1c</CssParameter>
              <CssParameter name="fill-opacity">0.6</CssParameter>
            </Fill>
            <Stroke>
           <CssParameter name="stroke">#000000</CssParameter>
           <CssParameter name="stroke-width">2</CssParameter>
         </Stroke>
          </PolygonSymbolizer>
          <TextSymbolizer>
          <Geometry>
             <ogc:Function name="centroid">
                <ogc:PropertyName>the_geom_zonas</ogc:PropertyName>
             </ogc:Function>
          </Geometry>
         <Label>
           <ogc:PropertyName>contador</ogc:PropertyName>
         </Label>
         <Font>
           <CssParameter name="font-family">Arial</CssParameter>
           <CssParameter name="font-size">12</CssParameter>
           <CssParameter name="font-style">normal</CssParameter>
           <CssParameter name="font-weight">bold</CssParameter>
         </Font>
         <LabelPlacement>
           <PointPlacement>
             <Displacement>
               <DisplacementX>0</DisplacementX>
               <DisplacementY>0</DisplacementY>
             </Displacement>
           </PointPlacement>
         </LabelPlacement>
         <Fill>
           <CssParameter name="fill">#000000</CssParameter>
         </Fill>
       </TextSymbolizer>
        </Rule>
        <Rule>
          <Name> Mayor 15</Name>
          <Title> Mayor 15</Title>
          <ogc:Filter>
            <ogc:PropertyIsGreaterThanOrEqualTo>
              <ogc:PropertyName>contador</ogc:PropertyName>
              <ogc:Literal>15</ogc:Literal>
            </ogc:PropertyIsGreaterThanOrEqualTo>
          </ogc:Filter>
          <MaxScaleDenominator>1.0E20</MaxScaleDenominator>
          <PolygonSymbolizer>
            <Fill>
              <CssParameter name="fill">#b10026</CssParameter>
              <CssParameter name="fill-opacity">0.6</CssParameter>
            </Fill>
            <Stroke>
           <CssParameter name="stroke">#000000</CssParameter>
           <CssParameter name="stroke-width">2</CssParameter>
         </Stroke>
          </PolygonSymbolizer>
          <TextSymbolizer>
          <Geometry>
             <ogc:Function name="centroid">
                <ogc:PropertyName>the_geom_zonas</ogc:PropertyName>
             </ogc:Function>
          </Geometry>
         <Label>
           <ogc:PropertyName>contador</ogc:PropertyName>
         </Label>
         <Font>
           <CssParameter name="font-family">Arial</CssParameter>
           <CssParameter name="font-size">12</CssParameter>
           <CssParameter name="font-style">normal</CssParameter>
           <CssParameter name="font-weight">bold</CssParameter>
         </Font>
         <LabelPlacement>
           <PointPlacement>
             <Displacement>
               <DisplacementX>0</DisplacementX>
               <DisplacementY>0</DisplacementY>
             </Displacement>
           </PointPlacement>
         </LabelPlacement>
         <Fill>
           <CssParameter name="fill">#000000</CssParameter>
         </Fill>
       </TextSymbolizer>
        </Rule>
      </FeatureTypeStyle>
    </UserStyle>
  </NamedLayer>
</StyledLayerDescriptor>
