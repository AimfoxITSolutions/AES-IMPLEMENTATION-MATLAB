function [ new_matrix ] = MatrixGenYxY(column,in)

for i=1:len
     new_matrix(row,[col]) =column(1,i);
     col = col + 1 ;
     if(col == 17)
        col = 1 ;
        row = row + 1;
     end
end

end

