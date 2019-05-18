function [ new_state ] = mixOfColumns( state )
%UNTITLED7 Summary of this function goes here
%   Detailed explanation goes here
temp_xor = 0;
new_state = [ 0 ; 0 ; 0 ; 0];
matrixmul = [2 3 1 1 ; 1 2 3 1 ; 1 1 2 3 ; 3 1 1 2];

for x = 1:4
    % for only first row and col
    for r = 1:4
        for c = 1:4
           temp =  matrixmul(r,c)* state(c,x);
           if (temp > 255)
                hex_no = dec2hex(temp);
                hex_n = [hex_no(2) hex_no(3) ];
                hex_n_dec = hex2dec(hex_n);
                temp = bitxor(hex_n_dec,27);
           end
          
           if(c == 2)
               temp_xor = bitxor(temp,temp1);
           end
            if(c>2)
                temp_xor = bitxor(temp,temp_xor); 
            end
           temp1 = temp;
        end  
        new_state(r,x) = temp_xor;

    end
    % here we had first row and col

end

end

